# Changelog

All notable changes to ITFlow will be documented in this file.

## 25.1
- Moved cron/cli scripts to scripts subfolder - Old scripts remain in the root for now, but please update your cron configurations!
- Bugfix: Ticket edit modal not showing multi-client/no-client projects
- Bugfix: Asset interface losing DHCP setting
- Bugfix: Editing / creating recurring expenses results in error 500 due to incorrect var name
- Stripe online payment setup now prompts you to set the income/expense account
- Admin pages now once again use the new admin role-check
- Debug now shows the current git branch
- Individual POST handler logic pages can no longer be accessed directly

## 24.12

- First introduced versioned releases!
