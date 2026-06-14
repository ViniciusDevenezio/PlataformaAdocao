# Security scan notes

## XSRF-TOKEN cookie

Laravel intentionally exposes the `XSRF-TOKEN` cookie to JavaScript so clients can read it and send the value back in the `X-XSRF-TOKEN` header. Because of that framework behavior, this cookie is not `HttpOnly`.

This is an accepted false positive for this project. The session cookie remains `HttpOnly`, `SameSite=Lax`, and secure in production HTTPS.

## POST /adotantes redirect

The registration controller redirects with Laravel redirect responses only. Password values are not flashed back to the session on manual validation redirects.

## Development dependency audit

`npm audit --omit=dev` reports no production dependency vulnerabilities. A development-only `vite/esbuild` advisory remains because npm only offers a breaking Vite upgrade for it.
