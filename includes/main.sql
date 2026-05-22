CREATE TABLE boards(
    id INT(11) NOT NULL AUTO_INCREMENT,
    board_name varchar(30) NOT NULL UNIQUE,
    board_short varchar(10) NOT NULL UNIQUE,
    PRIMARY KEY(id)
);
CREATE TABLE posts(
    id INT(11) NOT NULL AUTO_INCREMENT,
    post_title varchar(30),
    post_text TEXT NOT NULL,
    username varchar(30),
    img VARCHAR(255),
    parent_id INT(11),
    board_short varchar(10) NOT NULL,
    
    PRIMARY KEY(id),
    
    FOREIGN KEY(parent_id) REFERENCES posts(id) ON DELETE SET NULL,

    FOREIGN KEY(board_short) REFERENCES boards(board_short) ON UPDATE CASCADE
);
INSERT INTO boards (board_name, board_short) VALUES('GAMES', 'g');
INSERT INTO boards (board_name, board_short) VALUES('random', 'b');
INSERT INTO boards (board_name, board_short) VALUES('miku', 'm');

INSERT INTO posts (post_title, post_text, username, img, parent_id, board_short) VALUES('first post', 'hi, this is the first post', 'deku99hh', '../assets/123.png', null, 'g');
INSERT INTO posts (post_title, post_text, username, img, parent_id, board_short) VALUES('first comment', 'hi, this is the first comment', null, null, 1, 'g');
INSERT INTO posts (post_title, post_text, username, img, parent_id, board_short) VALUES('2nd post', 'hi, this is a post', null, '../assets/143.png', null, 'g');
INSERT INTO posts (post_title, post_text, username, img, parent_id, board_short) VALUES('comment', 'hi, this is a comment', null, null, 3, 'g');
INSERT INTO posts (post_title, post_text, username, img, parent_id, board_short) VALUES('2nd post', 'hi, this is a post', null, null, null, 'g');
