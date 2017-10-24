### Installation

- Make sure you have installed

  - [Docker](https://docs.docker.com)

  - [Docker Compose](https://docs.docker.com/compose)

  - [Git](https://git-scm.com)

  - [Make](https://www.gnu.org/software/make/manual)

- Add `mailbox.dev` to your hosts file 

- Spin up docker containers `$ docker-compose up -d`

- Install dependencies `$ make dependencies`
  
- Run database migrations `$ make db.migration.run`

### Documentation

- Generate documentation `$ make docs`

- Find documentation by [link](http://mailbox.dev/docs/api.html) 
