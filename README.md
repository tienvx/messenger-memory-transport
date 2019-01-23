# Memory Transport for Symfony Messenger [![Build Status][travis_badge]][travis_link] [![Coverage Status][coveralls_badge]][coveralls_link]

Extends the [Symfony Messenger](https://symfony.com/doc/master/components/messenger.html) component to
handle the memory transport.

The queuing is implemented as a *LIFO* (Last-In, First-Out) list.

This project is for testing purpose.

## Install

```bash
composer require tienvx/messenger-memory-transport
```

## Usage

1. Register the transport factory:

```yaml
#  config/services.yaml
Tienvx\Messenger\MemoryTransport\MemoryTransportFactory:
    tags: ['messenger.transport_factory']
```

2. Configure the Memory transport:
```yaml
#  config/packages/messenger.yaml
framework:
    messenger:
        transports:
            memory: "memory://any"
        routing:
            '*': memory
```

## Contributing

Pull requests are welcome, please [send pull requests][pulls].

If you found any bug, please [report issues][issues].

Thanks to
[everyone who has contributed][contributors] already.

## License

This package is available under the [MIT license](LICENSE).

[travis_badge]: https://travis-ci.org/tienvx/messenger-memory-transport.svg?branch=master
[travis_link]: https://travis-ci.org/tienvx/messenger-memory-transport

[coveralls_badge]: https://coveralls.io/repos/tienvx/messenger-memory-transport/badge.svg?branch=master&service=github
[coveralls_link]: https://coveralls.io/github/tienvx/messenger-memory-transport?branch=master

[wiki]: https://github.com/tienvx/messenger-memory-transport/wiki
[contributors]: https://github.com/tienvx/messenger-memory-transport/graphs/contributors
[pulls]: https://github.com/tienvx/messenger-memory-transport/pulls
[issues]: https://github.com/tienvx/messenger-memory-transport/issues
