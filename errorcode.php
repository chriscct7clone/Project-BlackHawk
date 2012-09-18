<?php
/* Debut of Project BlackHawk Errorcode 1.0 in BlackHawk 0.1.0 */
ob_start();
@set_time_limit(5);
@ini_set('memory_limit', '64M');
@ini_set('display_errors', 'Off');
error_reporting(0);
 
function print_error_page()
{
 
  $status_reason = array(
  /* Informational Codes */
  100 => 'Continue',
  101 => 'Switching Protocols',
  102 => 'Processing (WebDAV; RFC 2518)',
  /* Success Codes */
  200 => 'OK',
  201 => 'Created',
  202 => 'Accepted',
  203 => 'Non-Authoritative Information',
  204 => 'No Content',
  205 => 'Reset Content',
  206 => 'Partial Content',
  207 => 'Multi-Status',
  208 => 'Already Reported (WebDAV; RFC 5842)',
  226 => 'IM Used',
  269 => 'Call Back Later',
  300 => 'Multiple Choices',
  /* Redirection Codes */ 
  300 => '',
  301 => 'Moved Permanently',
  302 => 'Found',
  303 => 'See Other',
  304 => 'Not Modified',
  305 => 'Use Proxy',
  306 => 'Reserved',
  307 => 'Temporary Redirect',
  308 => '',
  /* Client Errors Codes */ 
  400 => 'Bad Request',
  401 => 'Unauthorized',
  402 => 'Payment Required',
  403 => 'Forbidden',
  404 => 'Not Found',
  405 => 'Method Not Allowed',
  406 => 'Not Acceptable',
  407 => 'Proxy Authentication Required',
  408 => 'Request Timeout',
  409 => 'Conflict',
  410 => 'Gone',
  411 => 'Length Required',
  412 => 'Precondition Failed',
  413 => 'Request Entity Too Large',
  414 => 'Request-URI Too Long',
  415 => 'Unsupported Media Type',
  416 => 'Requested Range Not Satisfiable',
  417 => 'Expectation Failed',
  418 => 'I\'m a teapot!',
  420 => '',
  422 => 'Unprocessable Entity',
  423 => 'Locked',
  424 => 'Failed Dependency',
  425 => '',
  426 => 'Upgrade Required',
  428 => '',
  429 => "",
  431 => "",
  444 => "",
  449 => "",
  450 => "",
  451 => "",
  494 => "",
  495 => "",
  496 => "",
  497 => "",
  499 => "",
  /* Server Errors Codes */
  500 => 'Internal Server Error',
  501 => 'Not Implemented',
  502 => 'Bad Gateway',
  503 => 'Service Unavailable',
  504 => 'Gateway Timeout',
  505 => 'HTTP Version Not Supported',
  506 => 'Variant Also Negotiates',
  507 => 'Insufficient Storage',
  508 => '',
  509 => '',
  510 => 'Not Extended',
  511 => '',
  598 => '',
  599 => '',
  /* BlackHawk Errors Codes */ 
  /* BlackHawk uses the unused 9xx (900-999) HTTP response range for the internal BlackHawk managment.*/
  /* BlackHawk 99x range is used for missing or garbled BlackHawk coes */
  999 => 'No Code'
  );
 
  $status_msg = array(
  /* No real person should ever hit error codes 100-307. Assume they are robots */
  /* TODO: "Blackhole Trap these */
  /* Informational Codes */
  100 => "This means that the server has received the request headers, and that the client should proceed to send the request body (in the case of a request for which a body needs to be sent; for example, a POST request). If the request body is large, sending it to a server when a request has already been rejected based upon inappropriate headers is inefficient. To have a server check if the request could be accepted based on the request's headers alone, a client must send Expect: 100-continue as a header in its initial request and check if a 100 Continue status code is received in response before continuing (or receive 417 Expectation Failed and not continue).",
  101 => "This means the requester has asked the server to switch protocols and the server is acknowledging that it will do so.",
  102 => "As a WebDAV request may contain many sub-requests involving file operations, it may take a long time to complete the request. This code indicates that the server has received and is processing the request, but no response is available yet. This prevents the client from timing out and assuming the request was lost.",
  /* Success Codes */
  200 => "Standard response for successful HTTP requests. The actual response will depend on the request method used. In a GET request, the response will contain an entity corresponding to the requested resource. In a POST request the response will contain an entity describing or containing the result of the action. BlackHawk uses this status error code in some generic self checks.",
  201 => "The request has been fulfilled and resulted in a new resource being created.",
  202 => "The request has been accepted for processing, but the processing has not been completed. The request might or might not eventually be acted upon, as it might be disallowed when processing actually takes place.",
  203 => "The server successfully processed the request, but is returning information that may be from another source.",
  204 => "The server successfully processed the request, but is not returning any content.",
  205 => "The server successfully processed the request, but is not returning any content. Unlike a 204 response, this response requires that the requester reset the document view.",
  206 => "The server is delivering only part of the resource due to a range header sent by the client. The range header is used by tools like wget to enable resuming of interrupted downloads, or split a download into multiple simultaneous streams.",
  207 => "The message body that follows is an XML message and can contain a number of separate response codes, depending on how many sub-requests were made.",
  208 => "The members of a DAV binding have already been enumerated in a previous reply to this request, and are not being included again."
  226 => "The server has fulfilled a GET request for the resource, and the response is a representation of the result of one or more instance-manipulations applied to the current instance.",
  269 => "The server has received the request and needs time to process it asynchronously. The client should make a corresponding GET request again later. The server may specify this URI and callback timestamp with the X-Callback-At and X-Callback-In headers, respectively.",
  /* Redirection Codes */ 
  300 => "Indicates multiple options for the resource that the client may follow. It, for instance, could be used to present different format options for video, list files with different extensions, or word sense disambiguation.",
  301 => "This and all future requests should be directed to the given URI.",
  302 => "This is an example of industry practice contradicting the standard. The HTTP/1.0 specification (RFC 1945) required the client to perform a temporary redirect (the original describing phrase was \"Moved Temporarily\"), but popular browsers implemented 302 with the functionality of a 303 See Other. Therefore, HTTP/1.1 added status codes 303 and 307 to distinguish between the two behaviours.However, some Web applications and frameworks use the 302 status code as if it were the 303.",
  303 => "The response to the request can be found under another URI using a GET method. When received in response to a POST (or PUT/DELETE), it should be assumed that the server has received the data and the redirect should be issued with a separate GET message.",
  304 => "Indicates the resource has not been modified since last requested. Typically, the HTTP client provides a header like the If-Modified-Since header to provide a time against which to compare. Using this saves bandwidth and reprocessing on both the server and client, as only the header data must be sent and received in comparison to the entirety of the page being re-processed by the server, then sent again using more bandwidth of the server and client.",
  305 => "Many HTTP clients (such as Mozilla and Internet Explorer) do not correctly handle responses with this status code, primarily for security reasons.",
  306 => "No longer used. Originally meant \"Subsequent requests should use the specified proxy.\"",
  307 => "In this case, the request should be repeated with another URI; however, future requests can still use the original URI. In contrast to how 302 was historically implemented, the request method should not be changed when reissuing the original request. For instance, a POST request must be repeated using another POST request.",
  308 => "The request, and all future requests should be repeated using another URI. 307 and 308 (as proposed) parallel the behaviours of 302 and 301, but do not allow the HTTP method to change. So, for example, submitting a form to a permanently redirected resource may continue smoothly.",
  /* Client Errors Codes */ 
  400 => "Your browser sent a request that this server could not understand.",
  401 => "This server could not verify that you are authorized to access the document requested.",
  402 => 'The server encountered an internal error or misconfiguration and was unable to complete your request.',
  403 => "You don't have permission to access %U% on this server.",
  404 => "Requested file does not exist.",
  405 => "The requested method is not allowed for the URL %U%.",
  406 => "An appropriate representation of the requested resource %U% could not be found on this server.",
  407 => "An appropriate representation of the requested resource %U% could not be found on this server.",
  408 => "Server timeout waiting for the HTTP request from the client.",
  409 => 'The server encountered an internal error or misconfiguration and was unable to complete your request.',
  410 => "The requested resource %U% is no longer available on this server and there is no forwarding address. Please remove all references to this resource.",
  411 => "A request of the requested method GET requires a valid Content-length.",
  412 => "The precondition on the request for the URL %U% evaluated to false.",
  413 => "The requested resource %U% does not allow request data with GET requests, or the amount of data provided in the request exceeds the capacity limit.",
  414 => "The requested URL's length exceeds the capacity limit for this server.",
  415 => "The supplied request data is not in a format acceptable for processing by this resource.",
  416 => 'Requested Range Not Satisfiable',
  417 => "The expectation given in the Expect request-header field could not be met by this server. The client sent <code>Expect:</code>",
  418 => "This is a real value, defined in 1998",
  420 => "Not part of the HTTP standard, but returned by the Twitter Search and Trends API when the client is being rate limited.[13] Other services may wish to implement the 429 Too Many Requests response code instead.",
  422 => "The server understands the media type of the request entity, but was unable to process the contained instructions.",
  423 => "The requested resource is currently locked. The lock must be released or proper identification given before the method can be applied.",
  424 => "The method could not be performed on the resource because the requested action depended on another action and that other action failed.",
  425 => 'The server encountered an internal error or misconfiguration and was unable to complete your request.',
  426 => "The requested resource can only be retrieved using SSL. Either upgrade your client, or try requesting the page using https://",
  428 => "The origin server requires the request to be conditional. Intended to prevent \"the 'lost update' problem, where a client GETs a resource's state, modifies it, and PUTs it back to the server, when meanwhile a third party has modified the state on the server, leading to a conflict.\"",
  429 => "",
  431 => "",
  444 => "",
  449 => "",
  450 => "",
  451 => "",
  494 => "",
  495 => "",
  496 => "",
  497 => "",
  499 => "",
  /* Server Errors Codes */ 
  500 => 'The server encountered an internal error or misconfiguration and was unable to complete your request.',
  501 => "This type of request method to %U% is not supported.",
  502 => "The proxy server received an invalid response from an upstream server.",
  503 => "The server is temporarily unable to service your request due to maintenance downtime or capacity problems. Please try again later.",
  504 => "The proxy server did not receive a timely response from the upstream server.",
  505 => 'The server encountered an internal error or misconfiguration and was unable to complete your request.',
  506 => "A variant for the requested resource <code>%U%</code> is itself a negotiable resource. This indicates a configuration error.",
  507 => "The method could not be performed.  There is insufficient free space left in your storage allocation.",
  508 => "",
  509 => "",
  510 => "A mandatory extension policy in the request is not accepted by the server for this resource.",
  511 => "",
  598 => "",
  599 => "",
  /* BlackHawk Errors Codes */ 
  /* BlackHawk uses the unused 9xx (900-999) HTTP response range for the internal BlackHawk management.*/
  /* BlackHawk 99x range is used for missing or garbled BlackHawk coes */
  999 => "No code given."
  );
 
  // Get the Status Code
  if (isset($_SERVER['REDIRECT_STATUS']) && ($_SERVER['REDIRECT_STATUS'] != 200))$sc = $_SERVER['REDIRECT_STATUS'];
  elseif (isset($_SERVER['REDIRECT_REDIRECT_STATUS']) && ($_SERVER['REDIRECT_REDIRECT_STATUS'] != 200)) $sc = $_SERVER['REDIRECT_REDIRECT_STATUS'];
  $sc = (!isset($_GET['error']) ? 404 : $_GET['error']);
 
  $sc=abs(intval($sc));
 
  // Redirect to server home if called directly or if status is under 400
  if( ( (isset($_SERVER['REDIRECT_STATUS']) && $_SERVER['REDIRECT_STATUS'] == 200) && (floor($sc / 100) == 3) )
     || (!isset($_GET['error']) && $_SERVER['REDIRECT_STATUS'] == 200)  )
  {
      @header("Location: http://{$_SERVER['SERVER_NAME']}",1,302);
      die();
  }
  
  // if 404 return back to previous page
  if ($sc == 404){
  // TO DO: add redirect
  }
 
  // Check range of code or issue 500
  if (($sc < 200) || ($sc > 599)) $sc = 500;
 
  // Check for valid protocols or else issue 505
  if (!in_array($_SERVER["SERVER_PROTOCOL"], array('HTTP/1.0','HTTP/1.1','HTTP/0.9'))) $sc = 505;
 
  // Get the status reason
  $reason = (isset($status_reason[$sc]) ? $status_reason[$sc] : '');
 
  // Get the status message
  $msg = (isset($status_msg[$sc]) ? str_replace('%U%', htmlspecialchars(strip_tags(stripslashes($_SERVER['REQUEST_URI']))), $status_msg[$sc]) : 'Error');
 
  // issue optimized headers (optimized for your server)
  @header("{$_SERVER['SERVER_PROTOCOL']} {$sc} {$reason}", 1, $sc);
  if( @php_sapi_name() != 'cgi-fcgi' ) @header("Status: {$sc} {$reason}", 1, $sc);
 
  // A very small footprint for certain types of 4xx class errors and all 5xx class errors
  if (in_array($sc, array(400, 403, 405)) || (floor($sc / 100) == 5))
  {
    @header("Connection: close", 1);
    if ($sc == 405) @header('Allow: GET,HEAD,POST,OPTIONS', 1, 405);
  }
 
  echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n<html>";
  echo "<head>\n<title>{$sc} {$reason}</title>\n<h1>{$reason}</h1>\n<p>{$msg}<br />\n</p>\n";
}
 
function askapache_global_debug()
{
  # http://www.php.net/manual/en/function.array-walk.php#100681
  global $_GET,$_POST,$_ENV,$_SERVER;  $g=array('_ENV','_SERVER','_GET','_POST');
  array_walk_recursive($g, create_function('$n','global $$n;if( !!$$n&&ob_start()&&(print "[ $"."$n ]\n")&&array_walk($$n,
    create_function(\'$v,$k\', \'echo "[$k] => $v\n";\'))) echo "<"."p"."r"."e>".htmlspecialchars(ob_get_clean())."<"."/"."pr"."e>";') );
}
 
print_error_page();
//if($_SERVER['REMOTE_ADDR']=='youripaddress')askapache_global_debug();
echo "</body>\n</html>";
echo ob_get_clean();
exit;
?>