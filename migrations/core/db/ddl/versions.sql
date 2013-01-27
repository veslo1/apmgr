-- script versions, keeps an internal record of the current database
-- you will create your internal storate db with this
-- author Jorge Vazquez <jvazquez@debserverp4.com.ar>


-- Table version is the main file that shows the current version of the tables.
-- Revision the current version of the database.
-- comments Write an optional comment about the reasson of this migration.

CREATE TABLE versions (
	revision INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	iscurrent INTEGER NOT NULL DEFAULT 0,
	comments TEXT NULL,
	dateCreated DATETIME NOT NULL,
	dateUpdated DATETIME NULL
);

CREATE INDEX "revision" ON "versions" ("revision");

-- Table history shows all the history of the migration system.
-- From verion is the version that the migration system was.
-- To version is the version that the database was downgraded / upgraded to.
-- userId The user that modified the migration system.

CREATE TABLE history (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	versionFrom INTEGER NOT NULL,
	versionTo	INTEGER NOT NULL,
	userId		INTEGER NOT NULL,
	dateCreated DATETIME NOT NULL,
	dateUpdated	DATETIME NULL
);

CREATE INDEX "id" ON "history" ("id");

-- The users that has access to this application.
-- name The real name of this user.
-- email The real email of this user , where to contact him.

CREATE TABLE users (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	name TEXT NOT NULL,
	email TEXT NOT NULL,
	dateCreated DATETIME NOT NULL,
	dateUpdated DATETIME NULL
);