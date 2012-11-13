# firstImpression.js
firstImpression is a JavaScript micro-library that answers the question, "Has this visitor been here before?" It's mostly a wrapper for a **plain JS** port of [jquery.cookie](https://github.com/carhartl/jquery-cookie). No other libraries required.

`firstImpression()` returns `true` for a new user, `false` for a returning user. Calling `firstImpression()` also sets a cookie if one does not already exist. The default cookie name is `_firstImpression` and the default expiration is 2 years (730 days).

## Usage
```javascript
// Basic usage
if ( firstImpression() ) {
  console.log('New user');
}

// Specify cookie name
if ( firstImpression('foo') ) {
  console.log('New user');
}

// Specify cookie name and expiration in days
if ( firstImpression('foo', 365) ) {
  console.log('New user');
}
```

## Removing cookies
```javascript
// Remove default cookie
firstImpression(null);

// Remove custom named cookie
firstImpression('foo', null);
```
## Browser Support
This should work in any browser that supports cookies. Tested in Chrome, Firefox, Opera, IE6-10, iOS, Android, and Opera Mobile.

## Contact
[@robflaherty](https://twitter.com/#!/robflaherty)

## License
Licensed under the MIT and GPL licenses.
