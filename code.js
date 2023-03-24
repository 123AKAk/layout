    // onload of page get all data
    window.onload = getAllData;

    $("#addData-form").submit(function (event)
    {
        var name = $("#name").val();
        var price = $("#price").val();

        if (name == "" || price == "")
        {
            alertify.error("Fill all Input Feilds");
        }
        else
        {
           
            let formdata = new FormData();
            formdata.append("name", name);
            formdata.append("price", price);
            
            let loca = "classes/components/userComponents.php?dataPurpose=addData";
            fetch(loca, { method: "POST", body: formdata })
                .then((res) => res.json())
                .then((data) => {
                console.log(data);
                var result = (data);
                if (result.response == true) 
                {
                    alertify.success(result.message);
                }
                else
                {
                    alertify.set({ delay: 15000 });
                    alertify.error(result.message);
                }
            });
        }
        getAllData();
        event.preventDefault();
    });

    function getAllData()
    {
        let formdata = new FormData();
        formdata.append("getData", '1')

        fetch("classes/components/userComponents.php?dataPurpose=getAllData", {
                method: "POST",
                body: formdata,
            })
            .then(res => res.json())
            .then(data => {
                console.log(data)
                
                //adds the data the table
                document.getElementById("showdata").innerHTML = data;
        });
    }

    function editData(pid)
    {
        var name = $("#name").val();
        var price = $("#price").val();

        let formdata = new FormData();
        formdata.append("name", name)
        formdata.append("price", price)
        formdata.append("pid", pid)
        
        fetch("classes/components/userComponents.php?dataPurpose=editData", {
                method: "POST",
                body: formdata,
            })
            .then(res => res.json())
            .then(data => {
                console.log(data)
                
                var result = (data);
                if (result.response == true) 
                {
                    alertify.success(result.message);
                }
                else
                {
                    alertify.set({ delay: 15000 });
                    alertify.error(result.message);
                }
        });
    }

    function deleteData(pid)
    {
        let formdata = new FormData();
        formdata.append("pid", pid)
        
        fetch("classes/components/userComponents.php?dataPurpose=deleteData", {
                method: "POST",
                body: formdata,
            })
            .then(res => res.json())
            .then(data => {
                console.log(data)
                
                var result = (data);
                if (result.response == true) 
                {
                    alertify.success(result.message);
                }
                else
                {
                    alertify.set({ delay: 15000 });
                    alertify.error(result.message);
                }
        });
    }