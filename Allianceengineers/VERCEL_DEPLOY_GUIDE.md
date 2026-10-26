# Alliance Engineers — Vercel deployment notes

This package adds Vercel's documented container configuration for PHP using FrankenPHP.

## Important before production
- Vercel containers have ephemeral local storage. Photos saved into `uploads/` may disappear after redeploys or when an instance changes. Move photo uploads to object storage (for example, Vercel Blob) before relying on this for real data.
- Use a separate MySQL server that permits external connections. Do not assume the InfinityFree database accepts connections from Vercel.
- Do not commit database credentials or `.env` files.
- Update the default admin password before making the site public.
- The app's analysis output is a college-project/demo aid, not certified structural engineering advice.

## Deploy
1. Extract this ZIP. The `AllianceEngineers_CollegeProject` folder is the project root.
2. Push that folder's contents to a private GitHub repository, including `Dockerfile.vercel`, `Caddyfile`, and `vercel.json`.
3. Import the repository into Vercel. If asked for the Root Directory, select the folder containing those three config files.
4. Add environment variables in Vercel Project Settings > Environment Variables:
   - `DB_HOST` — database hostname
   - `DB_PORT` — usually `3306`
   - `DB_NAME` — database name
   - `DB_USER` — database username
   - `DB_PASS` — database password
5. Create/import the database schema from `database.sql` into the target MySQL database. Remove the `CREATE DATABASE` and `USE` statements if your provider requires you to select the database first.
6. Deploy and test login, create-project, upload, BOQ and report routes.

The deployment will not work until a reachable external database is configured. This project currently saves uploaded photos to local `uploads/`, which is not durable on Vercel.
