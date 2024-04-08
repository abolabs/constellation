<div id="top"></div>
<!--
*** Thanks for checking out the Best-README-Template. If you have a suggestion
*** that would make this better, please fork the repo and create a pull request
*** or simply open an issue with the tag "enhancement".
*** Don't forget to give the project a star!
*** Thanks again! Now go create something AMAZING! :D
-->

<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->

[![Pipeline Status](https://gitlab.com/abolabs/constellation/badges/master/pipeline.svg)](https://gitlab.com/abolabs/constellation/commits/master)
[![Stars](https://badgen.net//gitlab/stars/abolabs/constellation/)](https://gitlab.com/abolabs/constellation/commits/master)
[![GitLab issues open](https://badgen.net/gitlab/open-issues/abolabs/constellation)](https://gitlab.com/abolabs/constellation/-/issues)
[![GitLab issues closed](https://badgen.net/gitlab/closed-issues/abolabs/constellation)](https://gitlab.com/abolabs/constellation/-/issues/?sort=weight&state=closed&first_page_size=20)
[![License: AGPL v3](https://img.shields.io/badge/License-AGPL_v3-blue.svg)](https://www.gnu.org/licenses/agpl-3.0)

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://gitlab.com/abolabs/constellation">
    <img src="doc/images/logo.png" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">Constellation</h3>

  <p align="center">
    IT service mapping interface
    <br />
    <br />
    <a href="https://gitlab.com/abolabs/constellation/-/issues">Report a Bug</a>
    ·
    <a href="https://gitlab.com/abolabs/constellation/-/issues">Request Feature</a>
  </p>
</div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#main-features">Main features</a></li>
      </ul>
      <ul>
        <li><a href="#hammer-built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#setup">Setup</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->

## About The Project

Constellation is an IT service mapping interface, enabling any IT organization to visualize and control its dependencies by application.

- Online demo: https://constellation.abolabs.fr/ (login: `demo@abolabs.fr`/ password: `demo`)

### Main features

- Modeling of applications and application services.
- Service management by version.
- Declaration of service dependencies according to 3 levels:
  - :large_blue_circle: **Minor**
    In the event of unavailability: impact on minor or major functionality(ies) with workaround solution.
  - :large_orange_diamond: **Major**
    In the event of unavailability: impact on major function(s) with no workaround but no general unavailability.
  - :red_circle: **Critical**
    In the event of unavailability: impact of one (or more) major function(s) with no workaround, resulting in general unavailability of the application.

<img src="doc/images/Screenshot.png" alt="Screenshot" width="500px" />

- **3 types of visualization possible**

  - Dependencies between applications
  - Service dependencies by application
  - Service dependencies by hosting solutions

- **Impact detection**

<img src="doc/images/impact_detection.gif" alt="Impact detection" width="500px" />

<p align="right" dir="">(<a href="#top">back to top</a>)</p>

### :hammer: Built With

#### API

- [Laravel](https://laravel.com)
- [MariaDB](https://mariadb.org/)
- [Meilisearch](https://www.meilisearch.com/)
- [Redis](https://redis.io/)

#### Web UI

- [React](https://react.dev) with [ReactAdmin](https://marmelab.com/react-admin/)
- [Cytoscape](https://js.cytoscape.org/)

<p align="right" dir="">(<a href="#top">back to top</a>)</p>

<!-- GETTING STARTED -->

## Getting Started

The instructions below show the various steps involved in initializing the application via Docker.

### Prerequisites

The app has been developed using the versions below:

- Docker version `21.0.6`, build `ed223bc`.
- Docker compose v2:
  - That means all commands with be executed with `docker compose ...` instead of `docker-compose ...`.
  - See [migration guide](https://docs.docker.com/compose/migrate/) to upgrade to v2.

Each service version is declared in the file `./install/dev/docker-compose.yml`.

### Setup

Step-by-step installation instructions are available in [./doc/Setup.md](./doc/Setup.md).

<!-- USAGE EXAMPLES -->

## Usage

Examples of uses

### Visualizing application dependencies

<img src="doc/images/Screenshot_2.png" alt="Visualization of application dependencies" width="500px" />

### Viewing service dependencies by application

<img src="doc/images/Screenshot.png" alt="Viewing service dependencies by application" width="500px" />

### Visualization of service dependencies by hosting solution

<img src="doc/images/Screenshot.png" alt="Visualization of service dependencies by hosting solution" width="500px" />

<p align="right" dir="">(<a href="#top">back to top</a>)</p>

<!-- CONTRIBUTING -->

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right" dir="">(<a href="#top">back to top</a>)</p>

<!-- LICENSE -->

## License

Distributed under GNU AFFERO GENERAL PUBLIC LICENSE. See [`LICENSE`](./LICENSE) for more information.

<p align="right" dir="">(<a href="#top">back to top</a>)</p>

<!-- CONTACT -->

## Contact

### Contributor(s)

(Creator) Alexandre Bordin - [@Linkedin](https://www.linkedin.com/in/alexandre-bordin/)

Project Link: [https://gitlab.com/abolabs/constellation](https://gitlab.com/abolabs/constellation)

<p align="right" dir="">(<a href="#top">back to top</a>)</p>
