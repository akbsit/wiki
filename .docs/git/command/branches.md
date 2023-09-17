# Working with branches

List of local branches:

```bash
git branch
```

Create a new branch with the specified name:

```bash
git branch <name>
```

Delete branch:

```bash
git branch -d <name>
```

Delete remote branch:

```bash
git push -d <remote> <name>
```

> Only deletes a branch if it is already fully merged in its upstream branch

```bash
git push --delete --force <remote> <name>
```

>Deletes regardless of its merged state

Show all available branches (including those on remote repositories):

```bash
git branch -a
```

Show a list of branches and the latest commit in each:

```bash
git branch -v
```

Go to the specified branch:

```bash
git checkout <name>
```

Create a new branch with the specified name and move to it:

```bash
git checkout -b <name>
```

Rollback changes to a file:

```bash
git checkout -- <name>
```
