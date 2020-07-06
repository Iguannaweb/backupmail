<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]




<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://github.com/Iguannaweb/backupmail">
    <img src="https://backupmail.iguannaweb.com/igw_template/assets/img/backupmail.png" alt="Logo" width="425" height="110">
  </a>

  <h3 align="center">What is BackupMail?</h3>

  <p align="center">
    I have a lot of mails accounts, I think it's a problem, but that is another question. One day thinking about backups my info I thounght how it will be to backups all my mails in my mail accounts, phisically.
    <br />
    <br />
    <strong>User demo:</strong> admin | <strong>Pass demo:</strong> backupmail
    <br />
    <br />
    <a href="#"><strong>&raquo; Explore the docs &laquo;</strong></a> 
    ·
    <a href="https://backupmail.iguannaweb.com/">&raquo; View Demo &laquo;</a>
    ·
    <a href="https://github.com/Iguannaweb/backupmail/issues">&raquo; Report Bug &laquo;</a>
    ·
    <a href="https://github.com/Iguannaweb/backupmail/issues">&raquo; Request Feature &laquo;</a>
    <br />
    <br />
    <strong>Send a sample email to:</strong> backupmail@iguannaweb.com
  </p>
</p>



<!-- TABLE OF CONTENTS -->
## Table of Contents

* [About the Project](#about-the-project)
  * [Built With](#built-with)
* [Getting Started](#getting-started)
  * [Prerequisites](#prerequisites)
  * [Installation](#installation)
* [Usage](#usage)
* [Roadmap](#roadmap)
* [Contributing](#contributing)
* [License](#license)
* [Contact](#contact)
* [Acknowledgements](#acknowledgements)



<!-- ABOUT THE PROJECT -->
## About The Project

[![Temporal screenshot][product-screenshot-1]](https://backupmail.iguannaweb.com/)

This is just a temporal screenshot, this is a work in progress!


### Built With

* [Love](https://www.iguannaweb.com)
* [Extra Time](https://www.iguannaweb.com)
* [& knowledge](https://www.iguannaweb.com)



<!-- GETTING STARTED -->
## Getting Started

To get your own backup mail working, you need a server with PHP7 and extension Mailparse installed. Yo need to install composer to fetch dependencies.

### Prerequisites

* [PHP 7](https://www.php.net/downloads.php)
* [Mailparse](https://www.php.net/manual/en/book.mailparse.php)
* [Composer](https://getcomposer.org/doc/00-intro.md)

### Install mailparse extension

#### Ubuntu, Debian & derivatives
```
sudo apt install php-cli php-mailparse
```

#### Others platforms
```
sudo apt install php-cli php-pear php-dev php-mbstring
pecl install mailparse
```

#### From source

AAAAMMDD should be `php-config --extension-dir`
```
git clone https://github.com/php/pecl-mail-mailparse.git
cd pecl-mail-mailparse
phpize
./configure
sed -i 's/#if\s!HAVE_MBSTRING/#ifndef MBFL_MBFILTER_H/' ./mailparse.c
make
sudo mv modules/mailparse.so /usr/lib/php/AAAAMMDD/
echo "extension=mailparse.so" | sudo tee /etc/php/7.1/mods-available/mailparse.ini
sudo phpenmod mailparse
```

#### Windows
You need to download mailparse DLL from http://pecl.php.net/package/mailparse and add the line "extension=php_mailparse.dll" to php.ini accordingly.

- [Help installing on plesk](https://talk.plesk.com/threads/installing-the-php-extensions-mailparse-mbstring.352973/)


### Installation
 
1. Clone the backupmail repository
```sh
git clone https://github.com/Iguannaweb/backupmail.git
```
2. Run composer install to fetch dependencies
```sh
php composer.phar install
```
3. Create a mysql database and import the file _backupmail.sampledb.sql_

4. Modify _dbc.sample.php_ with the database credentials and rename to **dbc.php**




<!-- USAGE EXAMPLES -->
## Usage

1. First of all you need to protect the access to your domain if it will be public. Create a .htaccess/.htpassword files
2. Config one mail on the config.mail.sample.php, rename to config.mail.php and check the connection con ./cron_mail.php.
3. Start fetching your mails, navigate and tag them all!
4. Create task or favorite your preferred mails.

_For more examples, please refer to the [Documentation](https://backupmail.iguannaweb.com?go=docs)_



<!-- ROADMAP -->
## Roadmap

See the [open issues](https://github.com/Iguannaweb/backupmail/issues) for a list of proposed features (and known issues).



<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request



<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.



<!-- CONTACT -->
## Contact

Francisco Gálvez - [Write me an email!](mailto:info@iguannaweb.com)  
If you want to contact me, the best way is write an email or open an issue here, I'm not really active on social networks.


Project Link: [https://github.com/Iguannaweb/backupmail](https://github.com/Iguannaweb/backupmail)


<!-- ACKNOWLEDGEMENTS -->
## Acknowledgements

* [You can be in this list!](https://github.com/Iguannaweb/backupmail/issues)
* [](...)



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/iguannaweb/backupmail.svg?style=flat-square
[contributors-url]: https://github.com/Iguannaweb/backupmail/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/iguannaweb/backupmail.svg?style=flat-square
[forks-url]: https://github.com/Iguannaweb/backupmail/network/members
[stars-shield]: https://img.shields.io/github/stars/iguannaweb/backupmail.svg?style=flat-square
[stars-url]: https://github.com/Iguannaweb/backupmail/stargazers
[issues-shield]: https://img.shields.io/github/issues/iguannaweb/backupmail.svg?style=flat-square
[issues-url]: https://github.com/Iguannaweb/backupmail/issues
[license-shield]: https://img.shields.io/github/license/iguannaweb/backupmail.svg?style=flat-square
[license-url]: https://github.com/Iguannaweb/backupmail/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=flat-square&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/crishnakh
[product-screenshot-1]: igw_template/images/screenshot1.png
[product-screenshot-2]: igw_template/images/screenshot2.png
