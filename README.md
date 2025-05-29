
## Tech Stack

### Frontend
- **React.js** - Component-based UI framework
- **React Bootstrap** - Responsive UI components
- **React Router** - Client-side routing
- **Axios** - HTTP client for API calls
- **React Hot Toast** - User notifications
- **EmailJS** - Email integration

### Backend
- **PHP 8.0** - Server-side scripting
- **MySQL 8.0** - Relational database
- **Apache** - Web server with SSL support
- **RESTful API** - Clean API architecture

### Infrastructure
- **Docker & Docker Compose** - Containerization
- **PhpMyAdmin** - Database management
- **SSL/HTTPS** - Secure connections
- **File Upload System** - Image storage and validation

## Quick Start

### Using Docker
```bash
git clone git@github.com:Wey4t/ubexchange.git
cd ubexchange
docker-compose up -d
npm install
npm start

```

## Environment Configuration

### Frontend (.env)
```env
REACT_APP_BASENAME=https://localhost/
```
### Backend Configuration
Database credentials are configured in:
- `api/database/db_connect.php`
- `docker-compose.yml`
