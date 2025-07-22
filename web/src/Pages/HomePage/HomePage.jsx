import React, { useState, useEffect } from "react";
import { api } from "../../lib/api";

export default function HomePage() {
  const [data, setData] = useState([]);
  const [selectedItem, setSelectedItem] = useState(null);

  const fetchData = async () => {
    const response = await api.get("/cooperado");
    setData(response.data);
  };

  useEffect(() => {
    fetchData();
  }, []);

  const handleAdd = () => {
    api
      .post("/cooperado", newItem)
      .then((response) => setData([...data, response.data]))
      .catch((error) => console.error("Erro ao adicionar registro:", error));
  };

  const handleEdit = (id) => {
    const newName = prompt("Digite o novo nome:");
    if (newName) {
      api
        .put(`/cooperado/${id}`, { name: newName })
        .then(() => {
          setData(
            data.map((item) =>
              item.id === id ? { ...item, name: newName } : item
            )
          );
        })
        .catch((error) => console.error("Erro ao editar registro:", error));
    }
  };

  const handleRemove = (id) => {
    api
      .delete(`/cooperado/${id}`)
      .then(() => setData(data.filter((item) => item.id !== id)))
      .catch((error) => console.error("Erro ao remover registro:", error));
  };

  const handleView = (item) => {
    setSelectedItem(item);
  };

  return (
    <div>
      <h1>Gerenciamento de Registros</h1>
      <button onClick={handleAdd}>Adicionar Registro</button>
      <div
        style={{
          display: "grid",
          gridTemplateColumns: "1fr 1fr 1fr",
          gap: "10px",
          marginTop: "20px",
        }}>
        {data.map((item) => (
          <div
            key={item.id}
            style={{
              border: "1px solid #ccc",
              padding: "10px",
              borderRadius: "5px",
              cursor: "pointer",
            }}
            onClick={() => handleView(item)}>
            <h3>{item.name}</h3>
            <button
              onClick={(e) => {
                e.stopPropagation();
                handleEdit(item.id);
              }}>
              Editar
            </button>
            <button
              onClick={(e) => {
                e.stopPropagation();
                handleRemove(item.id);
              }}>
              Remover
            </button>
          </div>
        ))}
      </div>
      {selectedItem && (
        <div
          style={{
            marginTop: "20px",
            padding: "10px",
            border: "1px solid #ccc",
            borderRadius: "5px",
          }}>
          <h2>Detalhes do Registro</h2>
          <p>
            <strong>ID:</strong> {selectedItem.id}
          </p>
          <p>
            <strong>Nome:</strong> {selectedItem.name}
          </p>
          <p>
            <strong>Descrição:</strong> {selectedItem.description}
          </p>
          <button onClick={() => setSelectedItem(null)}>Fechar</button>
        </div>
      )}
    </div>
  );
}
