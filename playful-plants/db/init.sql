
CREATE TABLE users (
 id INTEGER NOT NULL UNIQUE PRIMARY KEY AUTOINCREMENT,
 name TEXT NOT NULL,
 username TEXT NOT NULL UNIQUE,
 password TEXT NOT NULL
);

INSERT INTO
  users(id, name, username, password)
VALUES
  (
    1,'Menglin', 'menglin', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'
  );

CREATE TABLE sessions(
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  user_id INTEGER NOT NULL,
  session TEXT NOT NULL UNIQUE,
  last_login TEXT NOT NULL,
  FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE plants (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  plant_name TEXT NOT NULL UNIQUE,
  plant_id TEXT NOT NULL UNIQUE,
  Constructive_play INTEGER NOT NULL,
  Exploratory_Sensory_Play INTEGER NOT NULL,
  Physical_Play INTEGER NOT NULL,
  Imaginative_Play INTEGER NOT NULL,
  Restorative_Play INTEGER NOT NULL,
  Expressive_Play INTEGER NOT NULL,
  Play_Rules INTEGER NOT NULL,
  Bio_Play INTEGER NOT NULL,
  Perennial INTEGER NOT NULL,
  Annual INTEGER NOT NULL,
  Full_sun INTEGER NOT NULL,
  Partial_shade INTEGER NOT NULL,
  Full_shade INTEGER NOT NULL,
  file_ext TEXT
);

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (1, 'Pink Muhly Grass', 'GA_13', 1, 1, 1, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 'png');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (2, 'Feather reed grass', 'GA_01', 1, 1, 1, 1, 1, 0, 1, 1, 1, 0,1, 0, 0, 'png');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (3, 'Smooth Shadbush', 'SH_32', 0, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1,1, 0, 'png');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)

VALUES
  (4, 'Chestnut Oak', 'TR_29', 1, 1, 1, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 'jpg');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (5, 'Sideoats Grama', 'GA_20', 1, 1, 1, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0, 'png');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (6, 'Feverfew', 'GR_14', 0, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 0, 0, 'png');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (7, 'Prairie Cord Grass', 'GA_02', 1, 1, 1, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 'png');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (8, 'Christmas Fern', 'FE_01', 0, 1, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, 1, 'png');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (9, 'Climbing Hydrangea', 'VI_15', 0, 1, 1, 0, 1, 0, 0, 1, 1, 0, 0, 1, 1, 'jpg');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (10, 'New England Aster', 'FL_03', 0, 1, 0, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, 'jpg');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (11, 'Nannyberry', 'SH_34', 0, 1, 1, 0, 0, 0, 0, 1, 1, 0, 1, 1, 0, 'jpg');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (12, 'Hyssop', 'FL_30', 0, 1, 0, 1, 0, 0, 0, 1, 0, 0, 1, 1, 0, 'jpg');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (13, 'Linden', 'TR_05', 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 0, 'jpg');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (14, 'Sea Buckthorn', 'SH_21', 0, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 0, 0, 'jpg');


INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (15, 'Hedge Maple', 'TR_12-H', 1, 1, 1, 1, 1, 0, 0, 1, 1, 0, 1, 1, 0, 'jpg');

INSERT INTO
  plants (id, plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext)
VALUES
  (16, 'Smoketree', 'SH_28', 0, 1, 0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 'jpg');


  --- tags ---


CREATE TABLE tags (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  tag_name TEXT NOT NULL UNIQUE
);

INSERT INTO
  tags (id, tag_name)
VALUES
  (1, 'Shrub');

INSERT INTO
  tags (id, tag_name)
VALUES
  (2, 'Grass');

INSERT INTO
  tags (id, tag_name)
VALUES
  (3, 'Vine');

INSERT INTO
  tags (id, tag_name)
VALUES
  (4, 'Tree');

INSERT INTO
  tags (id, tag_name)
VALUES
  (5, 'Flower');

INSERT INTO
  tags (id, tag_name)
VALUES
  (6, 'Groundcovers');

INSERT INTO
  tags (id, tag_name)
VALUES
  (7, 'Edible');

INSERT INTO
tags (id, tag_name)
VALUES
  (8, 'Produce Scent');

INSERT INTO
tags (id, tag_name)
VALUES
  (9, 'Produce Sound');


  --- Foreign Key table ---


CREATE TABLE tags_plants (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  tags_id INTEGER NOT NULL,
  plant_id INTEGER NOT NULL,
  FOREIGN KEY(tags_id) REFERENCES tags(id),
  FOREIGN KEY(plant_id) REFERENCES plants(id)
);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (1, 2, 1);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (2, 2, 2);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (3, 9, 2);


INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (4, 1, 3);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (5, 7, 3);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (6, 8, 3);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (7, 4, 4);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (8, 7, 4);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (9, 2, 5);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (10, 6, 6);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (11, 7, 6);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (12, 8, 6);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (13, 2, 7);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (14, 7, 8);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (15, 3, 9);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (16, 8, 9);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (17, 5, 10);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (18, 7, 10);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (19, 1, 11);


INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (20, 7, 11);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (21, 8, 11);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (22, 5, 12);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (23, 7, 12);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (24, 8, 12);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (25, 4, 13);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (26, 7, 13);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (27, 8, 13);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (28, 1, 14);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (29, 7, 14);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (30, 4, 15);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (31, 7, 15);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (32, 9, 15);

INSERT INTO
  tags_plants (id, tags_id, plant_id)
VALUES
  (33, 1, 16);
