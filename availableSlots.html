<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Park'N Pay</title>
    <style>
        
        body {
            background-color: #118ab2;
            background-image: linear-gradient(319deg, #00b4eb 0%, #06d6a0 37%, #0056a2 100%);
            /* background: linear-gradient(135deg, #5899E2, #FFFFFF); */
            /* background-color: #fff; */

            /*background-image: linear-gradient(319deg, rgba(0,180,235,1) 0%, rgba(0,86,162,1) 50%, rgba(80,183,72,1) 100%);*/
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            /*display: flex; */
            justify-content: center;
            align-items: top;
            min-height: 100vh;
        }


        h1 {
            margin-top: 0;
            color: #181717;
            margin-bottom:0;
        }

        h2 {
            color: #242121;
            margin-top:0;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #3b3b3b;
        }

        select {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            color: #555;
        }

        /* Add some hover effect to the location cards */
        .location-card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease-in-out;
        }
        
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 100px;
            
        }

        .main-content{
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding:30px;
            flex-grow: 1;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto auto auto;
            gap: 20px 40px;
            margin-top: 30px;
            justify-content: space-around;
            justify-items: center; 
        }

        /* Style for location cards */
        .location-card {
            background-color: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%; /* Ensure cards take full width of the grid cell */
            transition: background-color 0.3s;
            background: linear-gradient(135deg, #80FF72, #7EE8FA);
        }

        .location-card h3 {
            color: #333;
            font-size: 24px;
        }

        .location-card p {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        /* Style for location cards with 0 available spots */
        .location-card.red {
            /* background-color: #FF8A8A; */
            background: linear-gradient(135deg, #FE0944, #FEAE96);
        }

        .footer {
            display: flex;
            justify-content: center; /* Horizontally center the content */
            align-items: center; /* Vertically center the content */
            margin-top: auto; /* Adjust as needed for spacing */
            width: fit-content;

        }

        .footer p {
            font-size: 18px; /* Set the font size */
            color: #555; /* Set the text color */
            margin: 0; /* Remove default margins to ensure proper alignment */
            padding: 10px; /* Add some padding for spacing */
            border-radius: 4px; /* Add rounded corners */
            text-align: center; /* Center align the text horizontally */
        }
        
        .footer img {
           
            max-width: 300px; /* Ensure the image doesn't exceed its original width */
        }

        @media (max-width: 1080px) {
            .container {
                padding: 10px;
            }

            .grid-container {
                grid-template-columns: auto auto auto;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .grid-container {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }
       
    </style>
</head>
<body>
    <div class="container">
        <div class="main_content">
            <h1 style="font-size: 60px;">Park'N Pay</h1>
            <h2 style="font-size: 32px;">Parking Management System</h2>
            <label for="locationSearch" style="font-size: 24px;">Search for a Location:</label>
            <input style="font-size: 18px; border-radius: 8px;"  type="text" id="locationSearch" placeholder="Enter location name...">
            <div id="gridContainer" class="grid-container">
                <!-- Location cards will be generated here -->
            </div>
        </div>
      <div class="footer">
        <p>Powered by </p>
          <img src="./images/logos/TheEmbryo.png" alt="avatar">
          
        
      </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const locationSearch = document.getElementById("locationSearch");
            const gridContainer = document.getElementById("gridContainer");
            // const locations = JSON.parse('<?php echo $jsonLocations; ?>');
            let locations = {};
            const output = document.getElementById("output");

            // Initial card generation
            fetch('availableSlotsApiPage.php')
                .then(response => response.json())
                .then(data => {
                    //call the card generation function
                    locations = data;
                    generateLocationCards(data);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
            

            // Function to generate location cards from data
            function generateLocationCards(data) {
                gridContainer.innerHTML = ""; // Clear existing cards

                for (const location in data) {
                    const card = document.createElement("div");
                    card.className = "location-card";

                    const name = document.createElement("h3");
                    name.textContent = `${data[location].location_name}`;
                    card.appendChild(name);

                    const availableSlots = document.createElement("p");
                    availableSlots.textContent = `Available Spots: ${data[location].available_slots}`;               
                    card.appendChild(availableSlots);

                    const available_slots = parseInt(`${data[location].available_slots}`);
                    

                    if (available_slots === 0) {
                        card.classList.add("red");
                    }
                    
                    gridContainer.appendChild(card);
                }
            }

            

            locationSearch.addEventListener("input", function () {
                const searchString = locationSearch.value.trim().toLowerCase();
                const filteredData = {};

                // Filter data based on the search string
                for (const location in locations) {
                    const locationName = locations[location].location_name.toLowerCase();
                    if (locationName.includes(searchString)) {
                        filteredData[location] = locations[location];
                    }
                }

                // Generate cards for filtered data
                generateLocationCards(filteredData);
            });
        });
    </script>
    
</body>


</html>

