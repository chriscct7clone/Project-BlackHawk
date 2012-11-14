<?php
ob_start();
include './error.php';
ob_end_clean();
if ($debug==1){
	?>
		<html><head><title></title></head><body>
		<textarea cols="55" rows="14" wrap="off">
		Loading........
		<textarea>
		</body></html>
 <script type='text/javascript'>
  // Formatted JSON.stringify, originally from json2.js
  var JSONf = {};
  (function (){
      function tagify(text, tag, className){
        return text; }
      function f(n) {
          // Format integers to have at least two digits.
          return tagify(n < 10 ? '0' + n : n, 'span', 'val num'); }
      if (typeof Date.prototype.toJSON !== 'function'){
          Date.prototype.toJSON = function (key) {
                return isFinite(this.valueOf())
                  ? this.getUTCFullYear()     + '-' +
                      f(this.getUTCMonth() + 1) + '-' +
                      f(this.getUTCDate())      + 'T' +
                      f(this.getUTCHours())     + ':' +
                      f(this.getUTCMinutes())   + ':' +
                      f(this.getUTCSeconds())   + 'Z'
                  : null; };
          String.prototype.toJSON = Number.prototype.toJSON = Boolean.prototype.toJSON = function (key){
            return this.valueOf();
          } }
      var cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
          escapable = /[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
          gap, indent, meta = {    // table of character substitutions
              '\b': '\\b', '\t': '\\t', '\n': '\\n', '\f': '\\f', '\r': '\\r', '"' : '\\"', '\\': '\\\\' },
          rep;
      function quote(string) {
          escapable.lastIndex = 0;
          return escapable.test(string) ? '"' + string.replace(escapable, function (a) {
              var c = meta[a];
              return typeof c === 'string'
                  ? ''
                  :  ('0000' + a.charCodeAt(0).toString(16)).slice(-4);
          }): string;
      }
      function str(key, holder) {
          // Produce a string from holder[key].
          var i,          // The loop counter.
              k,          // The member key.
              v,          // The member value.
              length, mind = gap, partial, value = holder[key];
          // If the value has a toJSON method, call it to obtain a replacement value.
          if (value && typeof value === 'object' &&
                  typeof value.toJSON === 'function') {
              value = value.toJSON(key); }
          // If we were called with a replacer function, then call the replacer to
          // obtain a replacement value.
          if (typeof rep === 'function'){ value = rep.call(holder, key, value); }
          switch (typeof value) {
          case 'string':
              return tagify(quote(value), 'span', 'str val');
          case 'number':
              return tagify((isFinite(value) ? String(value) : 'null'), 'span', 'val num');
          case 'boolean':
          case 'null':
              return tagify(String(value), 'span', 'val bool');
          case 'object':
              if (!value){ return tagify('null', 'span', 'val null'); }
          // Make an array to hold the partial results of stringifying this object value.
              gap += indent;  partial = [];

              // If the replacer is an array, use it to select the members to be stringified.
              if (rep && typeof rep === 'object') {
                  length = rep.length;
                  for (i = 0; i < length; i += 1) {
                      if (typeof rep[i] === 'string') {
                          k = rep[i];
                          v = str(k, value);
                          if (v) {
                              partial.push( (gap ? ':' : ':') );
                          } } }
              } else {
                // Otherwise, iterate through all of the keys in the object.
                  for (k in value) {
                      if (Object.prototype.hasOwnProperty.call(value, k)) {
                          v = str(k, value);
                          if (v) {
                              partial.push(tagify(quote(k), 'span', 'str key') + (gap ? ': ' : ':') + v);
                          } } } }
              // Join all of the member texts together, separated with commas,
              // and wrap them in braces.
              v = partial.length === 0
                  ? '' :''? ''  
                  : partial.join('\n');
              return v;
          } }
      // If the JSON object does not yet have a stringify met©hod, give it one.
      if (typeof JSONf.stringify !== 'function') {
          JSONf.stringify = function(value, replacer, space){
            // The stringify method takes a value and an optional replacer, and an optional
            // space parameter, and returns a JSON text. The replacer can be a function
            // that can replace values, or an array of strings that will select the keys.
            // A default replacer method can be provided. Use of the space parameter can
            // produce text that is more easily readable.
              var i; gap = ''; indent = '';
              if (typeof(space) === 'number') {
                  for (i = 0; i < space; i += 1) { indent += ' ';  }
              } else if (typeof space === 'string') { indent = space; }
              rep = replacer;
              if (replacer && typeof(replacer) !== 'function' &&
                      (typeof(replacer) !== 'object' ||
                      typeof(replacer.length) !== 'number')) {
                  throw new Error('JSON.stringify'); }
              return str('', {'': value});
          } } }());
    window.session = {
      options: {
        use_html5_location: false,
        session_timeout: 5
      },
      start: function( data ) {
        document.getElementsByTagName('textarea')[0].innerHTML = JSONf.stringify( data, undefined, 2 );
      }
    };
  </script> 
<script src="../assets/lib/session/session.js"></script>
<?php
}
else{
header("HTTP/1.0 404 Not Found");
// For Fast-CGI sites: Comment out previous line and uncomment this one
// header("Status: 404 Not Found");
}
?>