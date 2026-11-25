import { useState } from "react";

function CreateProduct() {
    //form in object to add many states in one state
    const [form, setForm] = useState({
        title_ar: "",
        title_en: "",
        sku: "",
        stock: "",
        price: "",
        status: "1",
        category_id: "1",
    });
    const [errors, setErrors] = useState({});
    const [success, setSuccess] = useState(null);
    const [image, setImage] = useState(null);

    function handleChange(e) {
        // copy data of the form and put name and value (key:value)
        setForm({ ...form, [e.target.name]: e.target.value });
        // console.log(form);
    }
    function handleSubmit(e) {
        e.preventDefault();
        setErrors({});
        setSuccess(null);

        const token = localStorage.getItem("token");

        const fd = new FormData();
        fd.append("title[en]", form.title_en);
        fd.append("title[ar]", form.title_ar);
        fd.append("sku", form.sku);
        fd.append("price", form.price);
        fd.append("stock", form.stock);
        fd.append("category_id", form.category_id);
        fd.append("status", form.status);
        if (image) fd.append("main-image", image);

        fetch("/api/create/product", {
            method: "POST",
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
            body: fd,
        })
            .then(async (response) => {  // funtion async has await rather than then then
                const data = await response.json(); //wait until json become ready
                if (response.status === 422) {
                    setErrors(data.errors);
                    return;
                }
                if (!response.ok) {
                    throw new Error(data.message || "Something went wrong");
                }
                setSuccess("Product created successfully ✅");
            })
            .catch((err) => setErrors({key :[err.message]}));   //{ sku: ["The sku has already been taken."] }
    }

    return (
        <div>
            <h2>Create Product</h2>
            {success && <p className="alert alert-success">{success}</p>}
            {Object.values(errors)  //{ sku: ["Taken"], price: ["Required", "Must be number"] }
                .flat()   // بيفرد ال array
                .map((msg, i) => (  //for every message if there is more than error
                    <p key={i} style={{ color: "red" }} className="alert alert-danger">
                        {msg}
                    </p>
                ))}
            <form onSubmit={handleSubmit} className="form">
                <input
                    name="stock"
                    type="number"
                    value={form.stock}
                    placeholder="Write the Stock"
                    onChange={handleChange}
                />
                <input
                    type="text"
                    name="sku"
                    value={form.sku}
                    placeholder="Write the sku"
                    onChange={handleChange}
                />
                <input
                    type="number"
                    name="price"
                    value={form.price}
                    placeholder="Write the price"
                    onChange={handleChange}
                />
                <input
                    name="title_ar"
                    value={form.title_ar}
                    placeholder="Write the title ar"
                    onChange={handleChange}
                />
                <input
                    name="title_en"
                    value={form.title_en}
                    placeholder="Write the title en"
                    onChange={handleChange}
                />
                <input
                    type="number"
                    name="category_id"
                    value={form.category_id}
                    placeholder="Write the id"
                    onChange={handleChange}
                />
                <select name="status" value={form.status} onChange={handleChange}>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <input type="file" onChange={(e) => setImage(e.target.files[0])} />  {/* 0 means first image */}
                <button type="submit" className="btn btn-primary">Create</button>
            </form>
        </div>
    );
}

export default CreateProduct;
