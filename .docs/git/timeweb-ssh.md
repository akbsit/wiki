# Setting up an SSH connection (using timeweb as an example)

If there is no SSH on the PC, then we generate keys:

```bash
ssh-keygen
```

First method (copy the SSH key to the server):

```bash
ssh-copy-id -i ~/.ssh/id_rsa <user>@<server>.timeweb.ru
```

Second method (copy the SSH key to the server):

```bash
scp ~/.ssh/id_rsa.pub <user>@<server>.timeweb.ru:~
```

Third method (on the server, if the key is in the root):

```bash
[ -d ~/.ssh ] || (mkdir ~/.ssh; chmod 700 ~/.ssh)
cat ~/id_rsa.pub >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
rm ~/id_rsa.pub
```
