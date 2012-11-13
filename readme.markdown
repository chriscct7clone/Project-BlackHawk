# Project BlackHawk #
Version 0.6.0   
[![Build Status](https://secure.travis-ci.org/chriscct7/Project-BlackHawk.png)](http://travis-ci.org/chriscct7/Project-BlackHawk)

## Program Description ##
A revolutionary new insanely great parking system ;) 
   
## Requirements ##
Server:
- PHP 5.2.17 or very close*
- MySQL 5.0 or higher
- Apache 2.2 or higher
- PHP bycrypt() library (optional)
- PHPMyAdmin or equivolent until install script is finalized

*Note: Unit Tests require 5.3+

We highly recommend running local testing on WAMPServer version 2.2 (64 bit with PHP 5.3.13)
If you have a Mac, use MAMP.

Client:
- Firefox, Internet Explorer 7/8/9/10 Beta*, Safari, Chrome, Opera*
- Javascript enabled
- Cookies enabled

IE 10 Beta and Opera support is based on **limited** testing. 
We **highly** recommend using a modern browser like Google Chrome or Mozilla Firefox.
We are testing/developing using Google Chrome version 22 or newer.

We use the following PEAR Libraries:
+ Symfony
+ Composer
+ PHPUnit
+ PHPDocumenter2

## Installation instructions ##
1. Unpack the archive.
2. Upload everything to your server.
3. Create a new MySQL database for BlackHawk.
4. Point your browser to (coming soon) and follow the instructions given.
5. If the installation was successful, delete (coming soon)

## How To Contribute ##
Please feel free to fork us and push back into the central Dev branch. Do not send pull request for the master branch. Ideally, please create a branch and pull request, based off the current Dev branch for each issue/bug/feature.
Please make sure you note all changes in the changelog.txt file in the following format:

    Project BlackHawk (version number) 
	+ (thing you added)
	- (thing you removed)
	
Unless you have approval, tack any changes onto current version.
If you get into a scenario where this happens:

    Project BlackHawk 0.1.0
	+ Added new Encryption Method X
	- Removed Encryption Method X
   
Remove both entries, **if and only if** they are in the same version number's changes.
   
## Found An Issue? ##
Please open a ticket in Github.  

## I would like to see feature X ##
You can vote on and request new features on our [Github Issues page](https://github.com/chriscct7/project-blackhawk/issues)

## Automated Source Testing ##
We test Project BlackHawk on every commit using a custom Travis-CI script (we are not currently using the default PHPUnit tests). In addition, we use Testify to test new PHPUnit Tests prior to inclusion in the tests folder. Find our Testify bundle in the vendors folder.
If you add something that you think you needs to be tested on every commit, create a new issue.

Build Status: [![Build Status](https://secure.travis-ci.org/chriscct7/Project-BlackHawk.png)](http://travis-ci.org/chriscct7/Project-BlackHawk)

## License conditions ##
Project BlackHawk is available under the terms and conditions of the
(coming soon).
Please see license.txt for full licensing terms and conditions.

## Code Standards: ##
+ PHPDocumenter2 compliant commenting
+ PSR-2 compliant
+ PSR-1 compliant
+ PSR-0 compliant minus class file naming
+ PEAR compliant minus error handling
+ Zend-Framework compliant minus class file naming and namespace management 

## Shelved Features: ##
Blackhawk had alot of features that were either done or near completition that did not make the final cut for the presentation. Some features would have taken too long to finish testing, or to document. Some were dropped do to legal reasons, and some were even done, but dropped due to stability reasons. These features will be added at a later date:
+ Gamification (rewards for parking smartly) (would not be finished in time)
+ Shortest Route/Parking by Schedule  (would not be finished in time)
+ Auto-ticket (legal reasons)
+ Advanced Live Statistics (stability)
+ Historical/Archived Statistics (stability)
+ BOSSCARS functionality
+ Reserved Spots
+ Premium Parking Mode
+ Targeted Advertisement by UID
//TODO: Add the rest from Github Issues to this

## Credits ##
- Project BlackHawk is (c) Chris Christoff, James Stephens, Steve Curry, and Stetson Gafford.
- Full credits in the credits.txt file.