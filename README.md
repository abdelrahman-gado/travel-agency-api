# Travel-agency-api

This is a simple Laravel API for a travel agency.

## Glossary
- Travel is the main unit of the project: it contains all the necessary information, like the number of days, the images, title, etc. An example is `Japan: road to Wonder or Norway: the land of the ICE;`.
  
- Tour is a specific dates-range of a travel with its own price and details. `Japan: Road to Wonder` may have a tour from 10 to 27 May at 1899 EGP, another one from 10 to 15 September at 669 EGP etc. In the end, you will book a tour, not a travel.

### Entity Relationship Diagram
![travel-agency-](./erd.png)
