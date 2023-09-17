# Copy

Copy the contents of the folder to another folder:

```bash
cp -rp <path to the source folder>/* <path to the destination folder>
```

Copy the contents of the folder from the remote computer to the local one:

```bash
scp -r <user>@<server>:<path to source folder> <path to destination folder>
```

Synchronizing files and folders from a remote computer to a local one:

```bash
rsync -avz <user>@<server>:<path to source folder> <path to destination folder>
```

Resuming the file in case of a break:

```bash
rsync -av --partial --rsh=ssh <user>@<server>:<path to source folder> <path to destination folder>
```
