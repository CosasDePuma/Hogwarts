-- --------------------------------------------------------

--
-- Base de datos: 'TikTak'
--

DROP DATABASE IF EXISTS tiktak;
CREATE DATABASE tiktak;
USE tiktak;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE users (
  ID        int NOT NULL UNIQUE AUTO_INCREMENT,
  username  varchar(20) NOT NULL UNIQUE,
  email     varchar(50) NOT NULL UNIQUE,
  passwd    varchar(100) NOT NULL,
  birthday  date NOT NULL,
  gender    varchar(1) NOT NULL,

  PRIMARY KEY (ID),
  CONSTRAINT chk_gender CHECK (gender = 'M' OR gender = 'F' OR gender = 'O')
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `follows`
--

CREATE TABLE follows (
  follower  int NOT NULL,
  follow    int NOT NULL,

  PRIMARY KEY (follower, follow),
  FOREIGN KEY (follow) REFERENCES users(ID),
  FOREIGN KEY (follower) REFERENCES users(ID)
);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

CREATE TABLE videos (
  ID          int NOT NULL UNIQUE AUTO_INCREMENT,
  user        int NOT NULL,
  title       varchar(100) NOT NULL,
  upload_date date NOT NULL,
  sharedtimes int,

  PRIMARY KEY (ID),
  FOREIGN KEY (user) REFERENCES users(ID)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE likes (
  user  int NOT NULL,
  video int NOT NULL,

  PRIMARY KEY (user, video),
  FOREIGN KEY (user) REFERENCES users(ID),
  FOREIGN KEY (video) REFERENCES videos(ID)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE comments (
  ID      int NOT NULL UNIQUE AUTO_INCREMENT,
  video   int NOT NULL,
  user    int NOT NULL,
  comment varchar(150) NOT NULL,

  PRIMARY KEY (ID),
  FOREIGN KEY (user) REFERENCES users(ID),
  FOREIGN KEY (video) REFERENCES videos(ID)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hashtags`
--

CREATE TABLE hashtags (
  ID    int NOT NULL UNIQUE AUTO_INCREMENT,
  tag   varchar(20) NOT NULL UNIQUE,

  PRIMARY KEY (ID)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `video_hashtags`
--

CREATE TABLE video_hashtags (
  video   int NOT NULL,
  hashtag int NOT NULL,

  PRIMARY KEY (video, hashtag),
  FOREIGN KEY (video) REFERENCES videos(ID),
  FOREIGN KEY (hashtag) REFERENCES hashtags(ID)
);