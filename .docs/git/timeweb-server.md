# Setting up GIT on the server (using timeweb as an example)

Login to the server via SSH:

```bash
ssh <user>@<server>.timeweb.ru
```

We go to the project folder, for example <example.com>, and initialize the repository there:

```bash
cd <example.com>
git init
```

Setting the settings for GIT on the server (if not already done):

```bash
git config --global user.name "<First Name Last Name>"
git config --global user.email <example@mail.com>
```

Checking settings:

```bash
git config --list
```

If the project folder is empty, then add an arbitrary file (for example .gitignore)

Let's make the first commit:

```bash
git add .
git commit -m "init"
```

Create a git folder in the root and go to it:

```bash
cd ~
mkdir git
cd git
```

Initialize the bare repository:

```bash
git clone --bare ../<example.com> <example.com>.git
```

We return to the project folder and configure remote for the project:

```bash
cd ~/<example.com>
git remote add origin ../git/<example.com>.git
```

Add the post-update hook to the bare repository and set the necessary file permissions:

```bash
cd ~/git/<example.com>.git/hooks
```

```bash
#!/bin/sh

cd /home/<first letter of user>/<user>/<example.com> || exit
unset GIT_DIR
git pull origin master

exec git-update-server-info
```

```bash
chmod +x post-update
```

Add a post-commit hook to the project repository:

```bash
cd ~/<example.com>/.git/hooks
```

```bash
#!/bin/sh
git push origin
```

```bash
chmod +x post-commit
```

We return to the project folder and push:

```bash
cd ~/<example.com>
git push --set-upstream shared master
```

Now you can clone it on your PC:

```bash
git clone ssh://<user>@<server>.timeweb.ru/home/<first letter of user>/<user>/<example.com>/git/<example.com>.git ./
```

> Work occurs as with a regular GIT repository

> Production is the master branch
