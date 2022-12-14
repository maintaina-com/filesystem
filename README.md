# A Filesystem library

- No dependencies
- No Framework Assumptions
- A nicer UX than strings, concatenation, split, arrays and DirectoryIterator
- OO approach using RelativePath, AbsolutePath, etc rather than ::isAbsolute ::isRelative
- Immutable Objects
- Path Objects cast to strings
- Using PHP 8.1+ expressiveness

## Basic usage

### Creating a PathInterface object

- Using the current working directory
AbsolutePath::currentWorkingDirectory() // The CWD as an absolute path

- Using any absolute path string
new AbsolutePath('/') // The Root Path
new AbsolutePath('/var/log') // The Root Path

- Using a relative path string
$path = new RelativePath('') // A relative self path
$path = new RelativePath('.') // A relative cwd path
$path = new RelativePath('..') // A relative one level up path
$path = new RelativePath('../var') // A relative path to a sibling "var" on the same level as cwd
$path = new RelativePath('../var') // A relative path to a sibling "var" on the same level as cwd

- If you do not know if it is a relative Path or an absolute Path
$path = Path::fromString($relativeOrAbsolute);

## Mutating

### Normalizing

Normalize autogenerated Paths to their standard representation for display, comparison etc

- remove any /./ level as it is a noop
- remove anny /../ level together with the preceding level as it is a noop
- remove trailing slashes
- collapse multiple slashes to one
- Absolute paths cannot exceed root

$normal = $path->normalize();

### Adding a level or a trailing slash

