# Admin Asset Layout

This project now keeps admin UI assets under `public/admin-assets`.

## Active runtime assets (current admin panel)

The current admin views (`@extends('adminlte::page')`) still use AdminLTE v3-compatible markup.
So runtime assets are loaded from:

- `public/admin-assets/adminlte3/dist`
- `public/admin-assets/plugins/*`

`resources/views/vendor/adminlte/master.blade.php` was updated to use these paths.

## Imported AdminLTE 4 package assets

From `AdminLTE-4.0.0-rc4.zip`, these files were extracted and placed in:

- `public/admin-assets/adminlte4/css`
- `public/admin-assets/adminlte4/js`
- `public/admin-assets/adminlte4/assets`

These are ready for migration work.

## Important compatibility note

AdminLTE v4 uses Bootstrap 5 and updated HTML/data attributes.
Current Laravel-AdminLTE v3 blade structure is not a drop-in match for v4.
To fully switch runtime to v4, view templates/layout markup must be migrated.
