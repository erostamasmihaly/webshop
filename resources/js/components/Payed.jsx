import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import {request} from '../helper'


const List = () => {

    const [items, setItems] = useState([]);
    useEffect(() => {
        
        // Adatok lekérdezése
        const fetchData = async () => {

            // GET kérés küldése a szervernek
            let response = await request('get', '/api/payed');

            // Lista feltöltése a válaszból
            setItems(response.data);  
        }

        fetchData().catch(console.error);

    }, []);

    return (
        <table className="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Név</th>
                    <th scope="col">Méret</th>
                    <th scope="col">Mennyiség</th>
                    <th scope="col">Tranzakció</th>
                    <th scope="col">Egységár</th>
                    <th scope="col">Művelet</th>
                </tr>
            </thead>
            <tbody>
                {items.map((item,index) => (
                    <tr key={index}>
                        <td>{ item.product_name }</td>
                        <td>{ item.size_name }</td>
                        <td>{ item.quantity } { item.unit_name }</td>
                        <td>{ item.transaction_id }</td>
                        <td>{ item.price_ft }</td>
                        <td>
                            <a href={"/react/product/"+item.id} className="btn btn-primary">Megtekintés</a>
                        </td>
                    </tr>
                ))}
            </tbody>
        </table>
    );

};

// Tartalom
function Payed() {
    return (
        <div>
            <h1>Eddigi vásárlások</h1>
            <List/>
        </div>
    );
}

// Tartalom betöltése
export default Payed;

if (document.getElementById('payed')) {
    const Index = ReactDOM.createRoot(document.getElementById("payed"));

    Index.render(
        <React.StrictMode>
            <Payed/>
        </React.StrictMode>
    )
}