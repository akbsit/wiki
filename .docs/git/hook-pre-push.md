# Setting up a GIT hook pre-push to push to multiple repositories

It is necessary to create a `pre-push` file with the following contents in the local repository in the `.git/hooks` folder:

```bash
#!/bin/sh

remote="$1"
url="$2"
current_branch=$(git symbolic-ref HEAD | sed -e 's,.*/\(.*\),\1,')

if [ $remote != <repository name> ]
then
     echo "Command: git push <repository name>" $current_branch
     git push <repository name> $current_branch
     echo ""
fi

exit 0
```

Next you need to add a remote repository:

```bash
git remote add <repository name> <link to remote repository>
```

> The abbreviated name of the remote repository must be called `<repository name>`. Otherwise, pre-push will not work.
