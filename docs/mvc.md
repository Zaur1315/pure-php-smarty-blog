# MVC Foundation

The project uses a lightweight custom mini MVC architecture.

---

## Request Flow

```text
Browser
→ public/index.php
→ Request
→ Router
→ Controller
→ View
→ Smarty template
→ Response
→ Browser
```

---

## Entry Point

Main application entry point:

```public/index.php```

Responsibilities:

- load Composer autoload
- create Request
- initialize Router
- load routes
- dispatch request
- send Response

---

## Request

Class:

```App\Core\Http\Request```

Responsibilities:

- read request method
- read request URI
- normalize URI
- provide clean access to request data

Methods:

- createFromGlobals()
- method()
- uri()

Example:

```php
$request = Request::createFromGlobals();

$request->method();
$request->uri();
```

---

## Response

Class:

```App\Core\Http\Response```

Responsibilities:

- store response content
- store status code
- send headers
- output final content

Methods:

- send()

Example:

```php
return new Response(
'<h1>Hello World</h1>',
200
);
```

---

## Router

Class:

```App\Core\Router\Router```

Responsibilities:

- register routes
- resolve routes
- execute controllers
- return Response

Supported methods:

- GET
- POST

Methods:

- get()
- post()
- dispatch()

Routes are stored in:

```config/routes.php```

Example:

```php
$router->get('/', [HomeController::class, 'index']);
```

---

## Controllers

Controllers are stored in:

```src/Controller```

Example:

```HomeController```

Responsibilities:

- handle page logic
- prepare data
- return Response

---

## View Layer

Class:

```App\Core\View\View```

Smarty is used as the template engine.

Responsibilities:

- configure Smarty
- assign template variables
- render templates

Templates are stored in:

```templates/```

Example:

```templates/home/index.tpl```

Render example:

```php
$view->render('home/index.tpl', [
'title' => 'Home',
'message' => 'Welcome',
]);
```

---

## Smarty Integration

Smarty directories:

```
storage/smarty/compile
storage/smarty/cache
storage/smarty/config
```

View internally uses:

```$smarty->fetch()```

to return rendered HTML.

---

## Project Structure

```
src/
├── Core/
│   ├── Http/
│   ├── Router/
│   └── View/
│
├── Controller/
├── Repository/
├── Service/
└── Seeder/
```

---

## Current Status

Implemented:

- Composer autoload
- Request
- Response
- Router
- Controller layer
- Smarty View wrapper
- Template rendering
- Route configuration
- MVC request lifecycle

---

[To top](#mvc-foundation)

[Back to Main](../README.md)