# Achievements Extension for DuRoom

## Features
- Reward your users with forum achievements
- Achievements are given when replying, liking, uploading an avatar, creating a new discussion and more...
- Achievements can include points and an icon

## Installation

```bash
composer require duroom/duroom-achievements
```

## Updating

```bash
composer update duroom/duroom-achievements
php duroom cache:clear
```

## Usage

Intructions on how to create achievements are on the corresponding admin page.

[See video](https://i.imgur.com/yYspfZF.mp4)

## Example

This is an example for an achievement with custom images:

- Name: Like-a-lot
- Active: yes
- Description: You liked more than 10 messages!
- Variable: Likes given 10
- Points for this achievement: 100
- Image URL: https://nucleoapp.com/assets/img/free-icons/free-glyph-icons@1x.png
- Image height: 96
- Image width: 96
- Row: 3
- Column: 5

You can look at the image we used for the example to understand how the image height, width, row and column works. You can also use one image per achievement, as long as the image has the exact size you want and you specify this size.

## Example 2

This is an example for an achievement with Font Awesome icons:

- Name: Leader
- Active: yes
- Description: You started more than 10 discussions!
- Variable: Discussions 10
- Points for this achievement: 250
- Image URL: far fa-comments

In this case, we are using the icon `far fa-comments` as our achievement image. Here, there is no need to specify the image size or anything else.
