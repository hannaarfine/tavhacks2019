CREATE TABLE `accounts` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`username`	TEXT NOT NULL UNIQUE,
	`password`	TEXT NOT NULL,
	`session`	TEXT UNIQUE
);

CREATE TABLE `images` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  `image_name` TEXT NOT NULL,
	`user_id` TEXT NOT NULL
);

CREATE TABLE `tags` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  `tag_name` TEXT NOT NULL UNIQUE
);

CREATE TABLE `image_tags` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`image_id` INTEGER NOT NULL,
	`tag_id` INTEGER NOT NULL
);

/* seed data */
INSERT INTO accounts (username, password) VALUES ('hanna', '$2y$10$93h4WRwvSAZNiypFhZQua.413KrJXmjPiSU1XZtZS7cgNlKRnm4Q2');
INSERT INTO accounts (username, password) VALUES ('dave', '$2y$10$AGTXEDtr6jqlvwzHGFFnWu/9YMFdL5q2C4jJeLIcK3JP3xXSqt.4C');

/* images */
INSERT INTO images (image_name, user_id) VALUES ('coast.jpg', 'hanna');
INSERT INTO images (image_name, user_id) VALUES ('desert.jpg', 'hanna');
INSERT INTO images (image_name, user_id) VALUES ('forest.jpg', 'hanna');
INSERT INTO images (image_name, user_id) VALUES ('treman.jpg', 'hanna');
INSERT INTO images (image_name, user_id) VALUES ('glacier.jpg', 'hanna');
INSERT INTO images (image_name, user_id) VALUES ('itasca.jpg', 'dave');
INSERT INTO images (image_name, user_id) VALUES ('lake.jpg', 'dave');
INSERT INTO images (image_name, user_id) VALUES ('mountains.jpg', 'dave');
INSERT INTO images (image_name, user_id) VALUES ('tetons.jpg', 'dave');
INSERT INTO images (image_name, user_id) VALUES ('yellowstone.jpg', 'dave');

INSERT INTO tags(tag_name) VALUES ('nature');
INSERT INTO tags(tag_name) VALUES ('beach');
INSERT INTO tags(tag_name) VALUES ('forest');
INSERT INTO tags (tag_name) VALUES ('desert');
INSERT INTO tags (tag_name) VALUES ('mountain');
INSERT INTO tags (tag_name) VALUES ('lake');

INSERT INTO image_tags(image_id, tag_id) VALUES (1, 2);
INSERT INTO image_tags(image_id, tag_id) VALUES (2, 4);
INSERT INTO image_tags(image_id, tag_id) VALUES (2, 1);
INSERT INTO image_tags(image_id, tag_id) VALUES (2, 3);
INSERT INTO image_tags(image_id, tag_id) VALUES (1, 1);
INSERT INTO image_tags(image_id, tag_id) VALUES (3, 1);
INSERT INTO image_tags(image_id, tag_id) VALUES (4, 1);
INSERT INTO image_tags(image_id, tag_id) VALUES (10, 1);
INSERT INTO image_tags(image_id, tag_id) VALUES (9, 5);
INSERT INTO image_tags(image_id, tag_id) VALUES (9, 10);
INSERT INTO image_tags(image_id, tag_id) VALUES (4, 3);
INSERT INTO image_tags(image_id, tag_id) VALUES (5, 3);
INSERT INTO image_tags(image_id, tag_id) VALUES (6, 1);
INSERT INTO image_tags(image_id, tag_id) VALUES (7, 1);
INSERT INTO image_tags(image_id, tag_id) VALUES (8, 5);
INSERT INTO image_tags(image_id, tag_id) VALUES (7, 6);
