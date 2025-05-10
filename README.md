# Web Digital Mantra IT Services – Blog RESTful API
This project is a Laravel-based RESTful API developed for managing blog content, including users, posts, and comments. It includes secure authentication, rate limiting, and relationship-based responses using Laravel Eloquent.

## 🔧 Features
## RESTful API Endpoints

Create, retrieve, update, and delete blog posts and comments.

Follows REST conventions with resource controllers and responses.

## Authentication

Secured using Laravel Sanctum.

API token-based authentication for user actions.

## API Rate Limiting

Rate limiting implemented using Laravel’s built-in ThrottleRequests.

Customizable per user or endpoint.

## Eloquent Relationships

Includes relationships between Users, Posts, and Comments.

Nested resource responses for better structure and usability.

## Pagination

Paginated API responses with metadata (links, meta) included.

Ensures performance and user-friendly output.

## 📡 API Endpoints
Method	Endpoint	Description
GET	/showPostsComments	Retrieve all posts with their associated comments
POST	/createPost	Create a new post
POST	/createComments	Create a new comment
PUT	/updatePost	Update an existing post
PUT	/updateComments	Update an existing comment
DELETE	/deletePost	Delete a post
DELETE	/deleteComments	Delete a comment

## 🔐 Authentication
    This API uses Laravel Sanctum for token-based authentication.

    Generate Token: On user login, a token is issued.

    Revoke Token: Tokens can be revoked during logout or as required.

## Include the token in the Authorization header:

    Authorization: Bearer {token}
    🌐 Access URLs (Localhost)
    Blog Page: http://127.0.0.1:8000/blogs

View Posts & Comments: http://127.0.0.1:8000/showPostsComments

## 📦 Installation
1. Clone the repository:

    git clone https://github.com/your-username/blog-api.git
    cd blog-api

2. Install dependencies:

    composer install

3. Setup environment:

    cp .env.example .env
    php artisan key:generate

4. Configure database in .env, then run:

    php artisan migrate

5. Start the server:

    php artisan serve

## 📄 License
This project is licensed under the MIT License.

