import React from 'react';
import ReactDOM from 'react-dom/client';

// Tartalom
function Payed() {
    return (
        <div>
            <h1>Eddigi vásárlások</h1>
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