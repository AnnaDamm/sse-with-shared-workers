This is an example on how Server Sent events can be used together with Shared workers to reduce connections.

# Prerequisites
* PHP >= 7.3

# Usage
To start the server:
```bash
    composer run start
```

Open either `with-worker.html` or `without-worker.html` in the browser.
To use a worker, you need some sort of webserver (nginx, apache) when opening the `with-worker.html`, because
the browser cannot load the worker file directly from the file system.

It is also possible to use PHPStorm's "Open in: Browser" feature to open the HTML file.

# Debug shared worker
In chrome, open: [chrome://inspect/#workers](chrome://inspect/#workers) and click on `inspect` of the service worker

In Firefox, open: [about:debugging#/runtime/this-firefox](about:debugging#/runtime/this-firefox) and click on `Inspect` of the service worker
