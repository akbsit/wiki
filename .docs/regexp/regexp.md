# Regular expressions

Limitation of the `(.+?)` construct:

```regexp
/\[url=\"([^\s"]+?)\"\](.+?)\[\/url\]/s
```

Checking the absence of the last character in a string:

```regexp
^(?!-)(?!.*--)[a-z0-9-]+(?<!-)$
```

> [link to solution source](https://stackoverflow.com/questions/4897353/regex-to-disallow-more-than-1-dash-consecutively)

Getting in line the first sentence:

```regexp
/^[^.]+/
```
