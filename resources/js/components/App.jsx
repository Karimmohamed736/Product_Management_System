import React from "react";
import Products from "./Products";
import Login from "./Login";
import CreateProduct from "./CreateProduct";

const App = () => {
    return (
        <>
            <header className="topbar">
                <h1>Product Management</h1>
                <Login />
            </header>
            <main className="layout">
                <section className="card">
                    <Products />
                </section>
                <aside className="card">
                    <CreateProduct />
                </aside>
            </main>
        </>
    );
};

export default App;
