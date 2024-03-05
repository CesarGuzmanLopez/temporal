<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LonghornOpen\LaravelCelticLTI\LtiTool;

class LtiController extends Controller
{
    public function getJWKS() {
        $tool = LtiTool::getLtiTool();
        return $tool->getJWKS();
    }

    public function ltiMessage(Request $request) {
        $tool = LtiTool::getLtiTool();

        $tool->handleRequest();

        if ($tool->getLaunchType() === $tool::LAUNCH_TYPE_LAUNCH) {
            /*
            At this point:
              $tool->platform describes the platform (LMS)
              $tool->context describes the context (course)
              $tool->resourceLink describes the resourceLink (tool placement in course)
              $tool->userResult describes the user.

            Each of these has a getRecordId() function which returns a database primary key.
            Store these keys in a session or in your app's database for later lookup.
            If your app has database tables corresponding to courses, users, etc you can store this primary key in that table.
            */

            //... application-launch logic here, which is probably just a redirect to a home page or dashboard of some kind.
            //... The app can use `Tool::getLtiTool()` to get an instance of the Tool object, and can use that object
            //...   to look up contexts, resourceLinks, userResults via the `getXXXXById()` functions, passing in the ID values
            //<w...   you stored in the session.
            // See https://github.com/celtic-project/LTI-PHP/wiki/Services for how to call LTI services such as the Names and Roles Provisioning Service.
        }

        die("Unknown message type");
    }
}
