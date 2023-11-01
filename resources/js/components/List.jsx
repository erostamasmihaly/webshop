import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import { getFetch } from '../helper_react';

const RenderProducts = () => {

    // Tároló és feldolgozó definiálása
    const [items, setItems] = useState([]);

    // Elemek lekérdezése
    useEffect(() => {
        getFetch('/api/list', setItems);
    }, []);

    // Visszatérés a táblázattal
    return (
        <div className="row gallery">
            {items.map((item,index) => (
                <div className="col-sm-2 text-center" key={index}>
                    <p className="fw-bold">{ item.name }</p>
                    <img src={ item.image } className="img-thumbnail"/>
                    <p>
                        { item.discount_price }<br/>
                        <a href={"/react/product/"+item.id} className="btn btn-primary">Megtekintés</a>
                    </p>
                </div>
            ))}
        </div>
    );

};

// Tartalom
function List() {
    return (
        <div>
            <h1>Termékek listája</h1>
            <RenderProducts/>
        </div>
    );
}

// Tartalom betöltése
export default List;

if (document.getElementById('list')) {
    const Index = ReactDOM.createRoot(document.getElementById("list"));
    Index.render(
        <React.StrictMode>
            <List/>
        </React.StrictMode>
    )
}