import { useState, useEffect } from "react";
import { api } from "../../lib/api";
import { DataGrid } from "@mui/x-data-grid";
import {
  Box,
  Button,
  Typography,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
} from "@mui/material";
import CooperadoFormModal from "../../components/CooperadoFormModal";
import { Edit, Delete, Visibility } from "@mui/icons-material";

export default function HomePage() {
  const [data, setData] = useState([]);
  const [selectedItem, setSelectedItem] = useState(null);
  const [modalOpen, setModalOpen] = useState(false);
  const [editingCooperado, setEditingCooperado] = useState(null);

  const fetchData = async () => {
    try {
      const response = await api.get("/cooperados");
      setData(response.data);
    } catch (error) {
      console.error("Erro ao buscar dados:", error);
    }
  };

  useEffect(() => {
    fetchData();
  }, []);

  const handleAdd = () => {
    setEditingCooperado(null);
    setModalOpen(true);
  };

  const handleEdit = (row) => {
    setEditingCooperado(row);
    setModalOpen(true);
  };

  const handleFormSubmit = async (formData) => {
    try {
      const response = editingCooperado
        ? await api.put(`/cooperados/${editingCooperado.id}`, formData)
        : await api.post("/cooperados", formData);

      setData((prev) =>
        editingCooperado
          ? prev.map((item) =>
              item.id === editingCooperado.id ? response.data : item
            )
          : [...prev, response.data]
      );
      setModalOpen(false);
    } catch (error) {
      console.error("Erro ao salvar cooperado:", error);
    }
  };

  const handleRemove = async (id) => {
    if (!confirm("Deseja realmente excluir este cooperado?")) return;
    try {
      await api.delete(`/cooperados/${id}`);
      setData((prev) => prev.filter((item) => item.id !== id));
    } catch (error) {
      console.error("Erro ao remover registro:", error);
    }
  };

  const formatCpfCnpj = (value) =>
    value.replace(
      value.length === 11
        ? /(\d{3})(\d{3})(\d{3})(\d{2})/
        : /(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/,
      value.length === 11 ? "$1.$2.$3-$4" : "$1.$2.$3/$4-$5"
    );

  const formatTelefone = (value) =>
    value.replace(/(\d{2})(\d{4,5})(\d{4})/, "($1) $2-$3");

  const columns = [
    { field: "nome", headerName: "Nome", flex: 1 },
    { field: "cpf_cnpj", headerName: "CPF/CNPJ", flex: 1 },
    {
      field: "data_nascimento_constituicao",
      headerName: "Data Nasc./Constit.",
      flex: 1,
      valueFormatter: (value) => {
        return new Date(value).toLocaleDateString("pt-BR");
      },
    },
    {
      field: "renda_faturamento",
      headerName: "Renda/Faturamento",
      flex: 1,
      valueFormatter: (value) =>
        Number(value).toLocaleString("pt-BR", {
          style: "currency",
          currency: "BRL",
        }),
    },
    { field: "telefone", headerName: "Telefone", flex: 1 },
    { field: "email", headerName: "Email", flex: 1 },
    {
      field: "actions",
      headerName: "Ações",
      flex: 1,
      sortable: false,
      renderCell: ({ row }) => (
        <>
          <Button
            variant="contained"
            color="success"
            size="small"
            onClick={() => handleEdit(row)}
            style={{ marginRight: 8 }}>
            <Edit />
          </Button>
          <Button
            variant="contained"
            color="error"
            size="small"
            onClick={() => handleRemove(row.id)}
            style={{ marginRight: 8 }}
            >
            <Delete />
          </Button>
          <Button
            variant="contained"
            color="info"
            size="small"
            onClick={() => setSelectedItem(row)}>
            <Visibility />
          </Button>
        </>
      ),
    },
  ];

  return (
    <Box sx={{ padding: 4 }}>
      <Box
        sx={{
          display: "flex",
          justifyContent: "space-between",
          alignItems: "center",
          mb: 2,
        }}>
        <Typography variant="h4" gutterBottom>
          Consulta de Cooperados
        </Typography>
        <Button variant="contained" color="primary" onClick={handleAdd}>
          Novo Cooperado
        </Button>
      </Box>

      <div style={{ height: 600, width: "100%" }}>
        <DataGrid
          rows={data.map((row) => ({
            ...row,
            cpf_cnpj: formatCpfCnpj(row.cpf_cnpj),
            telefone: formatTelefone(row.telefone),
          }))}
          columns={columns}
          initialState={{
            pagination: {
              paginationModel: { pageSize: 10 },
            },
          }}
          pageSizeOptions={[5, 10]}
          getRowId={(row) => row.id}
        />
      </div>

      {selectedItem && (
        <Dialog open={true} onClose={() => setSelectedItem(null)}>
          <DialogTitle>Detalhes do Cooperado</DialogTitle>
          <DialogContent dividers>
            {[
              { label: "Nome", value: selectedItem.nome },
              {
                label: "CPF/CNPJ",
                value: formatCpfCnpj(selectedItem.cpf_cnpj),
              },
              {
                label: "Data de Nascimento/Constituição",
                value: new Date(
                  selectedItem.data_nascimento_constituicao
                ).toLocaleDateString("pt-BR"),
              },
              {
                label: "Renda/Faturamento",
                value: Number(selectedItem.renda_faturamento).toLocaleString(
                  "pt-BR",
                  { style: "currency", currency: "BRL" }
                ),
              },
              {
                label: "Telefone",
                value: formatTelefone(selectedItem.telefone),
              },
              { label: "Email", value: selectedItem.email },
            ].map(({ label, value }) => (
              <Typography key={label}>
                <strong>{label}:</strong> {value}
              </Typography>
            ))}
          </DialogContent>
          <DialogActions>
            <Button onClick={() => setSelectedItem(null)} color="primary">
              Fechar
            </Button>
          </DialogActions>
        </Dialog>
      )}

      <CooperadoFormModal
        open={modalOpen}
        onClose={() => setModalOpen(false)}
        onSubmit={handleFormSubmit}
        initialData={editingCooperado}
      />
    </Box>
  );
}
