# Spatie Crawler Example for Cached Queue-Driver

This is an example of how a [Crawler](https://github.com/spatie/crawler) queue-driver can be cached and reused later. As an example it's rather simple and only intended to demonstrate core functionality. This is not intended to be used as a project.

The example is intended to be used with Docker as an locally-build image. The following commands build and run the crawler example:

```bash
docker build -t crawler-example -f ./Dockerfile .
docker run -p 8080:80 --rm crawler-example
```

After this, you can access it under `localhost:8080`. The main page of the example has an input field for the URL (ensure to have `https://` at the start!). With a click on 'Crawl' the crawler processes the first five pages of the provided URL. Below you see the `laravel.log` printed out to see the actions completed.

Please note:

- The print out of the log file isn't live and updates only with reloading of the page.
- The logging of the crawl actions is done separately as part of the [crawler toolkit](https://github.com/spekulatius/spatie-crawler-toolkit-for-laravel/). This toolkit is a set of classes bringing Laravel and Spatie Crawler closer together. It's intended to simplify the development of crawler applications.
- If your crawler doesn't crawl any more pages this might caused by having completed all discovered URLs. Try a different website to see if it works.

## This project is purely to demonstrate the functionality and shouldn't be used as it is. Please don't host this anywhere!
