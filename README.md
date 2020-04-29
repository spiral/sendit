SendIt
========
[![Latest Stable Version](https://poser.pugx.org/spiral/sendit/v/stable)](https://packagist.org/packages/spiral/sendit) 
[![Build Status](https://github.com/spiral/sendit/workflows/build/badge.svg)](https://github.com/spiral/sendit/actions)
[![Codecov](https://codecov.io/gh/spiral/sendit/branch/master/graph/badge.svg)](https://codecov.io/gh/spiral/sendit/)

Email builder and queue handler.

Example:
--------
The component provides the ability to compose content-rich email templates using Stempler views:

```html
<extends:layouts.email subject="Hello world"/>
<use:bundle path="sendit:bundle"/>

<email:attach path="path/to/file.file" name="attachment.file"/>

<block:body>
    <p>Hello, {{ $name }}!</p>
    <p><email:image path="path/to/image.png"/></p>
</block:body>
```

License:
--------
MIT License (MIT). Please see [`LICENSE`](./LICENSE) for more information. Maintained by [Spiral Scout](https://spiralscout.com).
