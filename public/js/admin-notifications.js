(function () {
    'use strict';

    var meta = document.querySelector('meta[name="admin-notifications-url"]');
    if (!meta) {
        return;
    }

    var pollUrl = meta.getAttribute('content');
    var pollIntervalMs = 30000;
    var lastKnownTotal = null;
    var initialMeta = document.querySelector('meta[name="admin-notifications-initial"]');

    if (initialMeta) {
        try {
            var initialCounts = JSON.parse(initialMeta.getAttribute('content'));
            if (initialCounts && typeof initialCounts.total === 'number') {
                lastKnownTotal = initialCounts.total;
            }
        } catch (error) {
            lastKnownTotal = null;
        }
    }
    var audioUnlocked = false;
    var audioContext = null;
    var pollTimer = null;

    function getBadge(id) {
        return document.querySelector('[data-notification-badge="' + id + '"]');
    }

    function updateBadge(id, count) {
        var badge = getBadge(id);
        if (!badge) {
            return;
        }

        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : String(count);
            badge.hidden = false;
        } else {
            badge.textContent = '';
            badge.hidden = true;
        }
    }

    function updateDashboardStats(data) {
        var messagesStat = document.querySelector('[data-stat="unread-messages"]');
        var admissionsStat = document.querySelector('[data-stat="unread-admissions"]');

        if (messagesStat) {
            messagesStat.textContent = String(data.messages);
        }

        if (admissionsStat) {
            admissionsStat.textContent = String(data.admissions);
        }
    }

    function ensureAudioContext() {
        if (!audioContext) {
            var AudioCtx = window.AudioContext || window.webkitAudioContext;
            if (!AudioCtx) {
                return null;
            }
            audioContext = new AudioCtx();
        }

        if (audioContext.state === 'suspended') {
            audioContext.resume();
        }

        return audioContext;
    }

    function unlockAudio() {
        if (audioUnlocked) {
            return;
        }

        var ctx = ensureAudioContext();
        if (!ctx) {
            return;
        }

        audioUnlocked = true;
    }

    function playNotificationSound() {
        var ctx = ensureAudioContext();
        if (!ctx || !audioUnlocked) {
            return;
        }

        var now = ctx.currentTime;

        function playTone(frequency, start, duration, volume) {
            var oscillator = ctx.createOscillator();
            var gain = ctx.createGain();

            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(frequency, start);

            gain.gain.setValueAtTime(0.0001, start);
            gain.gain.exponentialRampToValueAtTime(volume, start + 0.01);
            gain.gain.exponentialRampToValueAtTime(0.0001, start + duration);

            oscillator.connect(gain);
            gain.connect(ctx.destination);

            oscillator.start(start);
            oscillator.stop(start + duration + 0.02);
        }

        playTone(880, now, 0.12, 0.18);
        playTone(1174.66, now + 0.13, 0.16, 0.16);
    }

    function applyCounts(data, playSound) {
        updateBadge('messages', data.messages);
        updateBadge('admissions', data.admissions);
        updateDashboardStats(data);

        if (playSound && lastKnownTotal !== null && data.total > lastKnownTotal) {
            playNotificationSound();
        }

        lastKnownTotal = data.total;
    }

    function poll() {
        fetch(pollUrl, {
            method: 'GET',
            credentials: 'same-origin',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Notification poll failed');
                }

                return response.json();
            })
            .then(function (data) {
                applyCounts(data, true);
            })
            .catch(function () {
                // Ignore transient network errors; next poll will retry.
            });
    }

    function startPolling() {
        if (pollTimer) {
            clearInterval(pollTimer);
        }

        poll();

        pollTimer = setInterval(function () {
            if (document.visibilityState === 'visible') {
                poll();
            }
        }, pollIntervalMs);

        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') {
                poll();
            }
        });
    }

    document.addEventListener('click', unlockAudio, { once: true });
    document.addEventListener('keydown', unlockAudio, { once: true });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startPolling);
    } else {
        startPolling();
    }
})();
