# Production deploy (cPanel / Namecheap)

Planned site: https://nsangiparentsprimaryschool.com
Deployment is not configured yet. Set the server host, account, and application path after the new hosting account is ready.
This repository does not currently contain a GitHub Actions deployment workflow, so pushes will not deploy the site automatically.

## 1. Point the domain at Laravel `public`

In cPanel → **Domains** → `nsangiparentsprimaryschool.com` → edit **Document Root** to the `public` directory inside the application deploy path. Set the exact path after the hosting account is created.

## 2. Add GitHub Actions secrets

Repo → **Settings** → **Secrets and variables** → **Actions** → **New repository secret**

| Secret name | Value |
|---|---|
| `SSH_HOST` | Hostname supplied by the new hosting provider |
| `SSH_USER` | SSH account supplied by the new hosting provider |
| `SSH_PORT` | SSH port supplied by the new hosting provider |
| `SSH_PATH` | Absolute application path on the new server |
| `SSH_PRIVATE_KEY` | Private deployment key for the new hosting account |

Do **not** put the DB password in GitHub if `.env` already exists on the server (recommended). The workflow never overwrites `.env`.

## 3. Configure deployment

Once hosting is ready, add a deployment workflow that uses the secrets above, then push and verify the first deployment from GitHub Actions.

After the first successful deploy, seed once over SSH if the server database is empty. Use the new host's SSH details and application path:

```powershell
ssh <ssh-user>@<ssh-host>
cd <application-path>
php artisan db:seed --force
```

## Notes

- Builds run in GitHub Actions (`composer install --no-dev`, `npm run build`).
- The new server needs the PHP CLI version required by `composer.json` for `artisan migrate` and cache commands.
- Keep the server `.env` out of Git and configure its database credentials directly on the server.
