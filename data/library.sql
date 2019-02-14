CREATE TABLE forum (
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	created_by VARCHAR NOT NULL,
	created_at VARCHAR NOT NULL,
	title VARCHAR NOT NULL,
	content VARCHAR NOT NULL,
	upvotes INTEGER NOT NULL,
	downvotes INTEGER NOT NULL,
	img_location VARCHAR
);

INSERT INTO
	forum
	(
		created_by, created_at, title, content, upvotes, downvotes, img_location
	)
	VALUES(
		"Magnitude",
		datetime('now'),
		"POP POP",
		"Oh you know.",
		5,
		5,
		""
	);
	
INSERT INTO
	forum
	(
		created_by, created_at, title, content, upvotes, downvotes, img_location
	)
	VALUES(
		"Troy Barnes",
		datetime('now'),
		"Parting",
		"Never change. Or do. I'm not your boss.",
		9,
		1,
		""
	);
	
INSERT INTO
	forum
	(
		created_by, created_at, title, content, upvotes, downvotes, img_location
	)
	VALUES(
		"Doodles",
		datetime('now'),
		"Lorem and/or Ipsum",
		"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at varius purus, quis elementum sem. Pellentesque ac dapibus augue. Aliquam eget risus nibh. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed faucibus metus nisl, eget lacinia justo feugiat sit amet. Phasellus id tristique ligula. Phasellus placerat, velit nec molestie accumsan, est dui tempus ligula, quis mollis lectus mi sed lorem. Sed feugiat lorem quis leo rhoncus, vitae laoreet turpis iaculis. Aenean quis scelerisque mauris.",
		0,
		43,
		""
	);
	
INSERT INTO
	forum
	(
		created_by, created_at, title, content, upvotes, downvotes, img_location
	)
	VALUES(
		"Me",
		datetime('now'),
		"Zapp Brannigan",
		"If we hit that bullseye, the rest of the dominoes will fall like a house of cards.
		Checkmate.",
		20,
		2,
		""
	);
	
CREATE TABLE userVotes (
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	username VARCHAR KEY NOT NULL,
	postId INTEGER NOT NULL,
	vote VARCHAR NOT NULL
);

DROP TABLE IF EXISTS comment;

CREATE TABLE comment (
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	post_id INTEGER NOT NULL,
	created_at VARCHAR NOT NULL,
	created_by VARCHAR NOT NULL,
	content VARCHAR NOT NULL
);

INSERT INTO
	comment
	(
		post_id, created_at, created_by, content
	)
	VALUES(
		1,
		datetime('now'),
		"Somebody that i used to know",
		"BUT YOU DIDN'T HAVE TO CUUUUUT ME OOOOOOOOOOOFF."
	);
	
INSERT INTO
	comment
	(
		post_id, created_at, created_by, content
	)
	VALUES(
		3,
		datetime('now'),
		"Sir Reginald Mix-A-Lot II, Esquire",
		"I am fond of generous posteriors, hence i am unable to deceive."
	);

INSERT INTO
	comment
	(
		post_id, created_at, created_by, content
	)
	VALUES(
		3,
		datetime('now'),
		"second person",
		"I also am fond of generous posteriors, hence i am equally unable to deceive as the chap above."
	);
	
INSERT INTO
	comment
	(
		post_id, created_at, created_by, content
	)
	VALUES(
		1,
		datetime('now'),
		"a",
		"NEVER GONNA GIVE YOU UP."
	);

INSERT INTO
	comment
	(
		post_id, created_at, created_by, content
	)
	VALUES(
		1,
		datetime('now'),
		"b",
		"NEVER GONNA LET YOU DOWN."
	);

INSERT INTO
	comment
	(
		post_id, created_at, created_by, content
	)
	VALUES(
		1,
		datetime('now'),
		"c",
		"NEVER GONNA RUN AROUND AND HURT YOU."
	);
