create table admin (
    id       int auto_increment primary key,
    phn_num  varchar(30) not null,
    username varchar(50) not null,
    password varchar(50) not null,
    email    varchar(50) not null
);

create table customer (
    id       int auto_increment primary key,
    phn_num  varchar(30)  not null,
    name     varchar(50)  not null,
    gender   varchar(30)  not null,
    location varchar(100) not null,
    username varchar(50)  not null,
    password varchar(50)  not null
);

create table delivery_man (
    id       int auto_increment primary key,
    phn_num  varchar(30) not null,
    name     varchar(50) not null,
    username varchar(50) not null,
    password varchar(50) not null
);

create table restaurant (
    id       int auto_increment primary key,
    name     varchar(50)  not null,
    phn_num  varchar(30)  not null,
    location varchar(100) not null
);

create table food (
    id            int auto_increment primary key,
    picture_url   varchar(500) not null,
    name          varchar(50)  not null,
    description   varchar(500) not null,
    type          varchar(30)  not null,
    price         int          not null,
    restaurant_id int          not null,
    constraint foreign key (restaurant_id) references restaurant (id)
);

create table orders (
    id              int auto_increment primary key,
    customer_id     int         not null,
    restaurant_id   int         not null,
    delivery_man_id int         null,
    status          varchar(30) not null,
    total_amount    int         not null,
    constraint foreign key (customer_id) references customer (id),
    constraint foreign key (restaurant_id) references restaurant (id),
    constraint foreign key (delivery_man_id) references delivery_man (id)
);

create table food_order (
    food_id  int           not null,
    order_id int           not null,
    count    int default 1 not null,
    constraint foreign key (food_id) references food (id),
    constraint foreign key (order_id) references orders (id)
);

