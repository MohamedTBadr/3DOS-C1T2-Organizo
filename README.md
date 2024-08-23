# ThreeDOS - INSTANT - Case 1 Team 2 - ORGANIZO </br>

dbName is conference

Landing Page
```
The landing page has a set of Q&As near the footer that give some instructions
```
Signup (either by clicking start, become a member or the login button)
```
The form retains data upon submission failure, a convenience to the user
Adequate validation; including email validation e.g shehab@com wouldn't go through

Email verification: An OTP will be sent to verify the registeration
                    OTP has expiration and it can be resent when need be

Upon a successful registeration a welcoming message will be mailed
```
Login
```
The form retains data upon submission failure
The possible errors are: email not registered, invalid format, incorrect password
```
Forgot password 
```
An OTP will be sent to verify the ownership of that e-mail </br>
The OTP has expiration and it can be resent when need be </br>
Upon successfully reseting the password a message will be mailed to document this
```
User profile
```
The user can Edit info, change password, upgrade the subscription plan or logout
It shows the amount of projects the user is in, tasks assigned by or to the user
We chose to include the logout here instead of having it easily reachable from the navbar
```
Edit user profile
```
It allows the user to change Firstname, Lastname, phone number and to edit the profile picture,
since all users start with the default picture
```
Change password
```
It asks for the current password, the new password on top of confirming the new password
The new password has to conform with the critera of passwords as established
(having a minimum of a lowercase, uppercase, number and a special character)
Changing the password successfully will log the user out as a security measure
```
Subscription plans
```
It dynamically shows the plans that a user can upgrade to, depending on the user's current plan
It has a section that shows a neat comparison of the plans that shows up regardless of the current plan
```
Payment
```
It ensures that none  of the input is empty or invalid
```
My projects
```
Shows the user's projects, in addition to providing filters (All, In Progress, Comepleted) and a search
A project without sprints will have a due date of TBD (to be decided)
An "In progress" project is a project that has sprints, and tasks
A "Completed" project is a project that has all of its tasks across of all its sprints checked as "Done"
```
Add project
```
The user specifies the name of the project and can click on 'X' to back out
```
Edit project
```
It allows the user to change the project name
Add member: if the user's plan allows, as a freemium user can't add members
It checks if the current plan allows to add more members within the limit

Delete member: removes other team members (other than the user)
```
View Sprints
```
It shows a given project's sprints
It has pagination, where the limit is 3 sprints / page
Add sprint popup: set the sprint name, start and end date
                  the start date is set to current day's date for the user convenience but it can be changed
```
Edit sprint
```
Allows the user to edit the sprint name, start and end dates but within constraints that
relate to when is that change being done
```
Delete sprint </br>

Tasks </br>
Add comment </br>
Add task </br>
Delete task </br>
Archive task </br>
Task details </br>
Download image </br>
Edit task </br>
Archived tasks "to unarchive" </br>
Personal board </br>
Add note </br>
My task details </br>
Delete note </br>
Calendar </br>
