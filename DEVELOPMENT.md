# Front-end

## Dependencies

1. Latest version of [NodeJS](http://nodejs.org/) (min v6.0.0)
2. Latest version of one of the following package managers

-   [PNPM](https://pnpm.js.org/) (min v5.15)
-   [Yarn](https://yarnpkg.com/) (min v0.20.4)

## Install

In the `client` directory of the project run:

```
pnpm install
```

## Development

Edit files at `client/src` directory

## Build

To build the project, run:

```
yarn build
```

This command will generate an images sprite and build all assets(html, css and javascript) in the `client/dist` folder. Assets live in the `resources` folder.

## Configuration files

The build process configuration files live in `resources/build` directory.

# Back-end

## Install

Run

```
composer install
```

## Development

Edit files at `opts`, `inc`, `templates` directories

Opts - custom fields/options and objects

Inc - basic includes and WP customization

Templates - WP page templates
