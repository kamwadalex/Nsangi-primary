# Production deploy (cPanel / Namecheap)

Live site: https://nansanastjosephsss.com  
Deploy path: `/home/svuqjahdls/nansanastjosephsss.com`  
Trigger: push to `main` (or manual workflow dispatch)

## 1. Point the domain at Laravel `public`

In cPanel → **Domains** → `nansanastjosephsss.com` → edit **Document Root** to:

```text
/home/svuqjahdls/nansanastjosephsss.com/public
```

## 2. Add GitHub Actions secrets

Repo → **Settings** → **Secrets and variables** → **Actions** → **New repository secret**

| Secret name | Value |
|---|---|
| `SSH_HOST` | `66.29.148.146` |
| `SSH_USER` | `svuqjahdls` |
| `SSH_PORT` | `21098` |
| `SSH_PATH` | `/home/svuqjahdls/nansanastjosephsss.com` |
| `SSH_PRIVATE_KEY` | Full contents of `C:\Users\user\.ssh\nansana_cpanel_deploy` (private key file, including `BEGIN`/`END` lines) |

Do **not** put the DB password in GitHub if `.env` already exists on the server (recommended). The workflow never overwrites `.env`.

## 3. First deploy

```powershell
git add .github/workflows/deploy.yml
git commit -m "Add GitHub Actions cPanel deploy"
git push origin main
```

Then open GitHub → **Actions** and watch **Deploy to cPanel**.

After the first successful deploy, seed once over SSH if the database is empty:

```powershell
ssh -i ~/.ssh/nansana_cpanel_deploy -p 21098 svuqjahdls@66.29.148.146
cd ~/nansanastjosephsss.com
php artisan db:seed --force
```

## Notes

- Builds run in GitHub Actions (`composer install --no-dev`, `npm run build`).
- Server needs PHP CLI (you have 8.2) for `artisan migrate` / caches.
- Change the DB password in cPanel later if it was shared in chat, then update server `.env` to match.
