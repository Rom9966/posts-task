# Task Management Application

A full-stack application that fetches data from a public API, stores it in a database, and provides a user interface to view and search through the data.

## Tech Stack

- Backend: Laravel (PHP)
- Frontend: Vue.js
- Database: MySQL
- API: JSONPlaceholder (for demonstration)

## Features

- Fetch and store data from external API
- Display data in a user-friendly interface
- Search functionality to filter through data
- RESTful API endpoints
- Pagination for posts and search results
- Consistent API responses using Laravel API Resources
- Loader overlay in the frontend for better UX

## Setup Instructions

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL
- Git

### Backend Setup

1. Clone the repository
2. Navigate to the project directory
3. Install PHP dependencies:
   ```bash
   composer install
   ```
4. Copy `.env.example` to `.env` and configure your database settings:
   ```bash
   cp .env.example .env
   ```
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Run migrations:
   ```bash
   php artisan migrate
   ```
7. Start the Laravel development server:
   ```bash
   php artisan serve
   ```

### Frontend Setup

1. Navigate to the frontend directory
2. Copy the environment file:
   ```bash
   cp .env.example .env
   ```
3. Configure the API URL in `.env` if needed:
   ```
   VITE_API_URL=http://localhost:8000/api
   ```
4. Install dependencies:
   ```bash
   npm install
   ```
5. Start the development server:
   ```bash
   npm run dev
   ```

## Environment Variables

### Backend (.env)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Frontend (.env)
```
VITE_API_URL=http://localhost:8000/api
```

## API Endpoints & Response Structure

- `GET /api/posts` - Fetch all posts (paginated)
- `GET /api/posts/search` - Search posts (paginated)
- `POST /api/posts/sync` - Sync posts from external API

#### API Response Example (Paginated)

```
{
  "status": "success",
  "message": null,
  "data": {
    "data": [
      { "id": 1, "external_id": 1, "title": "...", ... },
      ...
    ],
    "links": { ... },
    "meta": {
      "current_page": 1,
      "last_page": 10,
      "per_page": 10,
      "total": 100
    }
  }
}
```

- Use `data.data` for the array of posts.
- Use `data.meta` for pagination info.

## Development Progress

This project is being developed with multiple commits to show the progression of development. Each commit represents a significant step in the development process. 