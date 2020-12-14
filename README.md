# WP Rules
Wordpress business workflow rules plugin.

## Product Overview:

We will start this project to help non developers to be able to create business rules without any programming knowledge.

### Some examples:-

1. You want to create a rule to **Send an email** to one of admins when an **editor publish a new post** with specific contents.
2. You want to create a rule to **Redirect Editors or one editor to a specific page** when **Logged in**.
3. You want to create a rule to **Change user meta field** when **user registers**.
4. You want to create a rule to **Send an email** (report) to admin when **the date is first day of every month**.

And too many options.

### Main Components:

![wp-rules](https://user-images.githubusercontent.com/15707971/100169234-9fd97700-2ecb-11eb-8d23-b847f55c0ef8.jpg)

**Rules:** Those are the business rules that will contain rule name, trigger, some conditions and actions inside it, like container only.

**Trigger:** This is the main entry for any active rule so this needs to be active to fire the process of checking conditions and perform actions, and basically this will be Wordpress Hooks ( actions ). 
**WE WILL START WITH ONE TRIGGER PER RULE FOR NOW.**

**Conditions:** Those are the conditions needs to be all true to perform actions.

**Actions:** Those are the actions that will be executed like sending email, show admin notice, ...etc.
