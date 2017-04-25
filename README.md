<img src="https://avatars0.githubusercontent.com/u/26927954?v=3&s=80" align="right" />

---

![Logo of install](docs/logo-large.png)

Installer for **binary-, phar-, shell- or batch-files from local or remote** source.

| [![Build Status](https://travis-ci.org/clickalicious/install.svg?branch=master)](https://travis-ci.org/clickalicious/install) 	| [![Codacy branch grade](https://img.shields.io/codacy/grade/8c129b9effb64446a8d2d30eaf305679/master.svg)](https://www.codacy.com/app/clickalicious/install?utm_source=github.com&utm_medium=referral&utm_content=clickalicious/install&utm_campaign=Badge_Grade) 	| [![Codacy coverage](https://img.shields.io/codacy/coverage/8c129b9effb64446a8d2d30eaf305679.svg)](https://www.codacy.com/app/clickalicious/install?utm_source=github.com&utm_medium=referral&utm_content=clickalicious/install&utm_campaign=Badge_Grade) 	| [![clickalicious open source](https://img.shields.io/badge/clickalicious-open--source-green.svg?style=flat)](https://www.clickalicious.de/) 	|
|---	|---	|---	|---	|
| [![GitHub release](https://img.shields.io/github/release/clickalicious/install.svg?style=flat)](https://github.com/clickalicious/install/releases) 	| [![license](https://img.shields.io/github/license/mashape/apistatus.svg)](https://opensource.org/licenses/MIT)  	| [![Issue Stats](https://img.shields.io/issuestats/i/github/clickalicious/install.svg)](https://github.com/clickalicious/install/issues) 	| [![Dependency Status](https://dependencyci.com/github/clickalicious/install/badge)](https://dependencyci.com/github/clickalicious/install)  	|


## Table of Contents

- [Features](#features)
- [Example](#example)
- [Requirements](#requirements)
- [Philosophy](#philosophy)
- [Versioning](#versioning)
- [Roadmap](#roadmap)
- [Security-Issues](#security-issues)
- [License »](LICENSE)


## Features

 - CLI- and Composer-Interface for installing files (binary-, phar-, shell- or batch-files) from local or remote source (URL)
 - Download files
 - Install files
 - Use directly from within your `composer.json`
 - High-quality & stable codebase (following PSR standards e.g. `PSR-1,4`)
 - Built on top of good PHP libraries
 - Clean + well documented code
 - Unit-tested with a good coverage


## Example

Use `clickalicious\install` in `composer.json` context for downloading and installing a binary:
```js
{
    "require": {
        "clickalicious/install": "^0.1"
    },
    "scripts": {
        "post-install-cmd": [
            "Install\\ScriptHandler::installFiles"
        ],
        "post-update-cmd": [
            "Install\\ScriptHandler::installFiles"
        ]
    },
    "extra": {
        "install-parameters": [{
    	    "file-uri": "https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar",
    	    "destination-filename": "foo.phar",
    	    "destination-directory": ".",
    	    "temporary-filename": "78d7fgs87sdf987sd89f",
    	    "temporary-directory": "/tmp",
            "install": true
        }]
    }
}
```

Use `clickalicious\install` in `CLI` context for downloading and installing a binary:
```shell
> vendor/bin/install --filename=FOO
```


## Requirements

 - `PHP >= 5.6` (compatible up to version `7.2` as well as `HHVM`)


## Philosophy

This library provides the capability of downloading files from an URL and/or install files like ...  .


## Versioning

For a consistent versioning i decided to make use of `Semantic Versioning 2.0.0` http://semver.org. Its easy to understand, very common and known from many other software projects.


## Roadmap

- [ ] Target stable release `1.0.0`
- [ ] `>= 90%` test coverage

[![Throughput Graph](https://graphs.waffle.io/clickalicious/install/throughput.svg)](https://waffle.io/clickalicious/install/metrics)


## Security Issues

If you encounter a (potential) security issue don't hesitate to get in contact with us `opensource@clickalicious.de` before releasing it to the public. So i get a chance to prepare and release an update before the issue is getting shared. Thank you!


## Participate & Share

... yeah. If you're a code monkey too - maybe we can build a force ;) If you would like to participate in either **Code**, **Comments**, **Documentation**, **Wiki**, **Bug-Reports**, **Unit-Tests**, **Bug-Fixes**, **Feedback** and/or **Critic** then please let me know as well!
<a href="https://twitter.com/intent/tweet?hashtags=&original_referer=http%3A%2F%2Fgithub.com%2F&text=Rng%20-%20Random%20number%20generator%20for%20PHP%20%40phpfluesterer%20%23Rng%20%23php%20https%3A%2F%2Fgithub.com%2Fclickalicious%2FRng&tw_p=tweetbutton" target="_blank">
  <img src="http://jpillora.com/github-twitter-button/img/tweet.png"></img>
</a>

## Sponsors

Thanks to our sponsors and supporters:

| JetBrains | Navicat |
|---|---|
| <a href="https://www.jetbrains.com/phpstorm/" title="PHP IDE :: JetBrains PhpStorm" target="_blank"><img src="https://resources.jetbrains.com/assets/media/open-graph/jetbrains_250x250.png" height="55"></img></a> | <a href="http://www.navicat.com/" title="Navicat GUI - DB GUI-Admin-Tool for MySQL, MariaDB, SQL Server, SQLite, Oracle & PostgreSQL" target="_blank"><img src="http://upload.wikimedia.org/wikipedia/en/9/90/PremiumSoft_Navicat_Premium_Logo.png" height="55" /></a>  |


###### Copyright
<div>Icons made by <a href="http://www.flaticon.com/authors/google" title="Google">Google</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
