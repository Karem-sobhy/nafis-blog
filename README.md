# Nafis Blog

Welcome to **Nafis Blog**! This is a simple blog application built with Laravel, designed to showcase the fundamentals of a modern blog, including post creation, nested comments, likes, and more.

## Features

- **User Authentication**: Register, login, and manage user sessions.
- **Blog Posts**: Create, update, and delete blog posts with ease.
- **Nested Comments**: Users can comment on posts and reply to comments, creating a thread.
- **Likes System**: Users can like posts.
- **Media Management**: Upload and manage images for posts using Spatie Media Library.
- **Pagination**: Blog posts and comments are paginated for efficient loading.

## Installation

### Prerequisites

- PHP 8.3 or higher
- Composer
- MySQL or MariaDB

### Setup Instructions

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Karem-sobhy/nafis-blog.git
   cd nafis-blog
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Set up environment variables:**
   Copy `.env.example` to `.env` and update the database credentials and other necessary settings:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations:**
   Migrate the database and seed some sample data if needed:
   ```bash
   php artisan migrate
   ```

5. **Serve the application:**
   Start the Laravel server:
   ```bash
   php artisan serve
   ```

6. **Access the application:**
   Visit `http://localhost:8000` in your browser.

## Usage

- Create an account and log in.
- Start creating blog posts with media attachments.
- Engage with other users by commenting and replying to posts.
- Like posts and comments to express appreciation.

## Development

### Code Structure

- **App/Models**: Contains the Eloquent models such as `Post`, `Comment`, and `User`.
- **App/Http/Controllers**: Handles the logic for requests, including CRUD operations and user interactions.
- **Database/Migrations**: Manages database schema changes.

### Key Technologies

- **Laravel**: PHP framework for backend logic.
- **Spatie Media Library**: For media handling (image uploads).
- **MySQL/MariaDB**: Relational database.

## Contributing

Feel free to fork the repository and submit pull requests to improve the blog or add new features.

### Steps to Contribute:

1. Fork the project.
2. Create a new branch:
   ```bash
   git checkout -b feature-new-feature
   ```
3. Commit your changes:
   ```bash
   git commit -m "Added a new feature"
   ```
4. Push the branch to your fork:
   ```bash
   git push origin feature-new-feature
   ```
5. Open a pull request.

## Contact

For any inquiries or feedback, feel free to reach out at [ksobhy@nafistech.com](mailto:ksobhy@nafistech.com).

---
