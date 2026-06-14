# Contributing Guidelines

Thank you for considering contributing to the Laravel Hetzner Robot SDK!

## Development Setup

1. Fork and clone the repository.
2. Install dependencies:
   ```bash
   composer install
   ```
3. Run tests:
   ```bash
   vendor/bin/phpunit
   ```
4. Run static analysis:
   ```bash
   vendor/bin/phpstan analyse
   vendor/bin/psalm
   ```
5. Apply code styling:
   ```bash
   vendor/bin/pint
   ```

## Pull Request Process

- Ensure the test suite passes 100%.
- Maintain 100% test coverage for new endpoints or features.
- Keep PHP 8.2+ compatibility guidelines in mind.
- Update documentation if exposing new methods or endpoints.
- Submit your pull request against the `main` or `master` branch.
