Project Make-a-Wish
===================

**[Project Make-a-Wish](https://makeawish.52poke.net/) (Pokémon 游戏中文化请愿/Pokémon 遊戲中文化請願)** is a petition campaign for Chinese-language support in Pokémon video games originally started in July 2014 by *koutian1xiaotu*. It contains online events across multiple fan communities including Baidu Tieba, Google+, Weibo and [52Poké](https://52poke.com/), as well as delivering a letter personally to top Pokémon officials at 2014 Pokémon World Championships in Washington, D.C..

This campaign collected more than 20,000 signature from around the world. [Pokémon Direct 2016.2.26](https://www.youtube.com/watch?v=DE9WJWp8zvs) officially announced Traditional Chinese and Simplified Chinese will be new language options in Pokémon Sun and Pokémon Moon. Both games released later on Nov 18, 2016. Since then, all main series Pokémon games, as well as many Pokémon spin-offs and mobile apps added Chinese-language support. This campaign has concluded a success.

This open source project is a updated version of the website of Project Make-a-Wish, and part of plan to open source [52Poké](https://github.com/mudkipme/52poke). It is updated to latest PHP, Laravel and Bootstrap versions and integrated with modern web technologies.

While the campaign has ended, the website will be kept to remember and treasure this precious time that we **connect (相连/相連)**.

## Requirements

* PHP 7.3 or later
* Composer
* Node.js
* Database supported by Laravel

## Installation

```bash
# install dependencies
composer install
npm install

# build frontend resources
npm run prod

# setup database
php artisan migrate

# create an admin user
php artisan user:create admin admin@localhost admin

# start the server
php artisan serve
```

The default configuration uses a Lorem Ipsum letter in four languages in [resources/lorem](resources/lorem).

## License

The programming source code is under [BSD-3-Clause](LICENSE).

*All texts under [resources/content](resources/content) and external images are proprietary of Project Make-A-Wish and/or its original writers, which are not allowed to be used without written permission.*

**If you create a campaign with the usage of source code under this project, you are *not allowed* to mention the name or the purpose of Project Make-A-Wish, as well as the names of its contributors in any of your user interface. BSD-3-Clause explicitly prohibits such endorsement.**

[Project Make-A-Wish](https://makeawish.52poke.net/) is created by Chinese-language Pokémon fan communities and not affiliated with Nintendo, Creatures, GAME FREAK and The Pokémon Company. Pokémon and related characters are copyright of the said companies and are not used in any beneficial way to us.
