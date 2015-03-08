/*************************************************/
/ Documentation Assignment 1 by Grüner, Ferdinand /
/*************************************************/


/**************************/
/ 1. Application Structure /
/**************************/

The Application consists of four sites which are selectable in the menu:

	- Courses: Displays all courses
	- People: Displays both, Lecturers and Students and their details
	- Grades: Displays grades in a sortable table (2. How to sort the grades)
	- Upload: Shows a page on which you can upload grades with a csv file (3. How to upload grades)



/*********************************************/
/ 2. How to sort the grades                   /
/*********************************************/

By selecting Grades in the menu, you get to the page displaying all grade records.
Next to each property you find two arrows:

The one pointing up will sort the table in an ascending order regarding your selected property.

The arrow pointing down does the exact opposite and sorts the table descending regarding your selected property.



/*********************************************/
/	3. How to upload grades               /
/*********************************************/

2.1 The csv structure

The structure of the uploadable csv file consists of four properties per row (of course all separated by a comma).

The first value is the studentId (you can find the student id under the people page),
the second one the courseId (you can find out a course id by looking in the data folder in the grade.txt -> its the first value),
the third one is the grade (A-F)
and the fourth one is the date the exam was taken or the grade was earned 
Format: Y-m-d  example: 2015-09-08

An example file can be found in the root directory (grade.txt).


2.2 The upload process 

To upload the grades you have to select Upload in the menu. This leads you to a page where you see two buttons.

Click the one saying Choose File. 

This opens a finder/explorer window where you can select a file (accepted filetypes are txt and csv).

Once the file is selected press the upload file button. 
Your file gets now checked and the valid grades are updated.

Validate, you ask? Yes, grades can only be updated when both the student and the course exist and the student never passed the exam before. 
But no worries, if you make a little mistake, the notification area will list up, what you have to correct. 




