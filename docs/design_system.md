# Design Systems 

## How the web application works
The home page (index.php) is loaded. From this page, we can select between the admin page, and the patient page. On the admin page, we can add a patient by adding information such as their first name, last name, and their severity. Once done, the patient is added to the database. The admin can then view the current state of the queue, and remove patients once they've been served based on their arrival time and severity. On the patient side, they have to input their code and last name. Once done, they can view their current position in the waiting list, and the estimated waiting time.

## Colours
|Section|Hex|Color|
|-----|--------|------|
|Background|#e9f0f8|![#e9f0f8](https://placehold.co/15x15/e9f0f8/e9f0f8.png) - Light blue|
|Font|#000000|![#000000](https://placehold.co/15x15/000000/000000.png) - Black|
|Buttons| #EFEFEF| ![#EFEFEF](https://placehold.co/15x15/EFEFEF/EFEFEF.png) - Light grey|
|Waitlist grid (patient side)|#ffffff| ![#ffffff](https://placehold.co/15x15/ffffff/ffffff.png) - White|
|Queue table head (admin side)| #e7e5e5| ![#e7e5e5](https://placehold.co/15x15/e7e5e5/e7e5e5.png) - Light grey|
|Queue table data (admin side)| #ffffff| ![#ffffff](https://placehold.co/15x15/ffffff/ffffff.png) - White|

## Home page
![Home page](/docs/assets/home_page.png)

## Admin page
![Admin page](/docs/assets/admin_page.png)

## Admin adding a patient successfully
![Patient added successfully](/docs/assets/added_patient_successfully.png)

## Admin queue
![Admin queue](/docs/assets/admin_queue.png)

## Patient page
![Patient page](/docs/assets/patient_page.png)

## No patient found
![No patient found](/docs/assets/no_patient_found.png)

## Patient waitlist
![Patient waitlist](/docs/assets/patient_waitlist.png)

## Relational model
![Relational model](/docs/assets/relation_model.png)

