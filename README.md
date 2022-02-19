### **[Click here to see Postman Collection](https://documenter.getpostman.com/view/529680/UVkjvxPz)**

## Helpful Commands

### `php artisan serve`

## Process to test App

- User will test this webApp in `Postman`
- User have to import collection in Postmana which I have attched with mail
- To use All the Loan Processs API, User have to create one token by using `register` or `login`

## API Documantation

### Register
`http://localhost:8000/api/register`
- Method `POST`
- By using this API, Customer can be created and in responce `token` will be genereted.

![image](https://user-images.githubusercontent.com/62538358/154794382-092772e6-b65d-4699-898f-70f157dc61b7.png)

### Login
`http://localhost:8000/api/login`
- Method `POST`
- By using this API, `token` will come as  response and it will be used to access all other process for Loan

![image](https://user-images.githubusercontent.com/62538358/154794824-eed310ae-0d7e-429d-b939-8f2d6a9f94c4.png)


### Add Loan Application
`http://localhost:8000/api/loans`
- Method `POST`
- By using this API new loan application will be created with `token` authentication

![image](https://user-images.githubusercontent.com/62538358/154794915-cbefeff4-d523-4362-b6d7-4b9771fc0a06.png)

### Show Loan Applications
`http://localhost:8000/api/loans`
- Method `GET`
- By using this API all the loan applications will be shown with `token` authentication

![image](https://user-images.githubusercontent.com/62538358/154794965-eb141335-fcb1-4a0c-8a91-ad13647769ba.png)

### Show Single Loan Application
`http://localhost:8000/api/loans/1`
- Method `GET`
- By using this API Single loan application will be shown with `token` authentication

![image](https://user-images.githubusercontent.com/62538358/154795010-f0f2dedf-c9a8-4ff5-b733-6a9afd09d2b7.png)

### Approve Loan Application
`http://localhost:8000/api/approveloan`
- Method `POST`
- By using this API loan application will be approved with `token` authentication

![image](https://user-images.githubusercontent.com/62538358/154795043-1b139b6d-ff22-4b6d-8f50-73b1c263c353.png)

### Repay Loan amount
`http://localhost:8000/api/repayment`
- Method `POST`
- By using this API loan replayment can be done with `token` authentication

- `When user repays on time, below output will come`

![image](https://user-images.githubusercontent.com/62538358/154795177-6eb7eb4e-dd74-47c2-92d5-f6586e60d001.png)

- `When user's payment is overdue, below output will come`

![image](https://user-images.githubusercontent.com/62538358/154795238-22f04541-566b-4da5-a5c9-97d0701d7105.png)





