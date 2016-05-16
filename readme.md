# Twitch Active Streams
Twitch Active Streams is a small project allowing for streamer communities to setup profiles for each streamer, and keep track of when each streamer last streamed.

## Current features
While the feature set is a bit lacking, the project is still available for hosting for those who wish to do so.

- Automatic checking of streams to see if they're live.
- Admin dashboard with the ability to add, edit, delete and restore deleted profiles.
- Profile supports formatting using BBCode.

## Planned features
The planned features have no ETA, but they are mentioned for the sake of keeping track of them.

- Allow users to edit their own profiles.
- Add the ability to allow other admins to be easily added through the dashboard.
    - Currently this has to be done manually through the database, by setting the `admin` column to `1` for the user you wish to give access to in the `users` database table.
- Move most, if not all, of the data processing to an internal API.

Feel free to suggest anything through the [Issues](/issues) tab

## Requirements
The following things are required for setting this up:
- [Laravel's requirements](https://laravel.com/docs/5.2/installation#server-requirements)
- [A database system that Laravel supports](https://laravel.com/docs/5.2/database#introduction)
- [Composer](https://getcomposer.org/)

## Setup
- Rename `.env.example` to `.env` and fill in the information. Primarly the database and Twitch information.
    - The `WEBSITE_TITLE` value in the `.env` file will display the title as a prefix to the page name. The format is `{WEBSITE_TITLE} - {PAGE_NAME}`.
    - You can create a Twitch application here: https://www.twitch.tv/settings/connections. The redirect URL has to be `http://example.com/auth/twitch/callback` (where `example.com` is **your domain**) and needs to be set the same under `TWITCH_REDIRECT_URI` in the `.env` file.
- Run `composer install` in the project directory.
- Run `php artisan key:generate` & `php artisan migrate` from the command line in the base project directory.
- Point your web server to the `/public` directory of the repo.
    - I recommend using apache2 and configuring it to set `AllowOverride` to `All` for the specific directory in the vhost, so the `.htaccess` file can set the settings.
- For the automatic checking of streams to work, a [cron entry](https://laravel.com/docs/5.2/scheduling) has to be setup.
    - If you have TwitchAS installed under `/var/www/twitchas`, the following cron entry applies:
        - `* * * * * php /var/www/twitchas/artisan schedule:run >> /dev/null 2>&1`
    - By default, streams are updated every **5** minutes.
    - By default, user avatars are updated **weekly**.
    - If you wish to modify the default times, look at the [scheduling docs for Laravel](https://laravel.com/docs/5.2/scheduling) and modify the `app/Console/Commands/Kernel.php` file.
