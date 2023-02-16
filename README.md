
# MyZenTeam code test assignment

## Description

Pinia is used for state management, but we could achieve the desired behavior with the function $emit to communicate between the child component Candidate.vue and the parent component Candidates and with the parent's parent App.vue and pass the variable coins as a prop to the CandidatesHeader.vue component, for example. With the stores, we could use the information in other components, and the information would be easily accessible and updated.

A supervisor could be implemented to have the queue worker run separately.

For the database, I don't need to have a server running for testing or using the application; I used sqlite but it should be implemented with mysql or mariaDB.

Left some suggestions, descriptions, and alternatives as comments.

To run the application, just follow the instructions:
1 - run the command "php artisan serve"
2 - in another terminal, run the command "npm run production"
3 - in another terminal, run the command "php artisan queue:work"

If you want to confirm that the emails are being sent and received, you can log in on mailtrap with the following credentials:
1 - user: "emailtestingtrapmail@gmail.com"
2 - pass: "MyZenTeam123*"


Please notice that I could disable the buttons when the candidate is contacted our hired, adjust the grid size, add a successful or error message after the requests for the contact and hire candidate, etc.
