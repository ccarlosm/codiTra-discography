//Create index for the README file

1. [About Discography](#about-discography)
2. [Requirements](#requirements)
3. [Installation](#installation)
4. [Deployment](#deployment)
5. [Usage](#usage)
6. [Comments](#comments)
7. [License](#license)

## About Discography

Discography is an API that allows users to CRUD albums and tracks. It is built using the Laravel framework v11

## Requirements

- PHP: Version 8.2 or higher.
- Composer: Version 2.x. Must be installed globally and accessible via the composer command.
- Docker:
* For Windows and Mac users: Docker Desktop 25.0 or higher. Docker Desktop includes Docker Compose, which is required for running Laravel Sail.
* For Linux users: Docker 25.0 or higher and Docker Compose. While Docker Desktop is not available for Linux, Docker Compose must be installed separately to work with Laravel Sail. Please follow the official Docker documentation to ensure Docker Compose is installed on your Linux system.

## Installation

1. Clone the repository
2. Run `install.sh` to install and start the docker containers with Laravel Sail
2. Run `bootstrap.sh` to run migrations and seeders

## Deployment

The API uses Laravel Sail to deploy in docker containers. To start the server, run `./vendor/bin/sail up` (or `./vendor/bin/sail up -d` with docker desktop) in the root directory of the project. The API will be available at `localhost:8080`

## Usage

The API has the following endpoints:

- GET /albums
- GET /albums/{id}
- POST /albums
- PUT /albums/{id}
- DELETE /albums/{id}
- GET /albums/{id}/tracks
- GET /albums/{id}/tracks/{track_id}
- POST /albums/{id}/tracks
- PUT /albums/{id}/tracks/{track_id} 
- DELETE /albums/{id}/tracks/{track_id}
- POST /register
- POST /login
- POST /logout
- GET /user
- PUT /user
- DELETE /user
- ....

The user created with the Database seeder has the following credentials:
- name: Test User
- email: test@example.com
- password: 123456

## Testing

Run the tests with `./vendor/bin/sail test --parallel`
The tests will be set up in a dedicated github action to be run in every pull request. See folder `.github/workflows` for more information.

## Comments

In a different and more complex case it would be interesting to add idempotency to the API to handle repetitive requests.
The quickest way would be to add a package like [`square1/laravel-idempotency`](https://packagist.org/packages/square1/laravel-idempotency) but it is not updated for Laravel 11 yet and for the task it is not necessary.

## License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
