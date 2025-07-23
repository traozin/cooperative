import {
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  TextField,
  Button,
  Grid,
} from "@mui/material";
import { useState, useEffect } from "react";

const initialFormState = {
  nome: "",
  cpf_cnpj: "",
  data_nascimento_constituicao: "",
  renda_faturamento: "",
  telefone: "",
  email: "",
};

export default function CooperadoFormModal({
  open,
  onClose,
  onSubmit,
  initialData,
}) {
  const [form, setForm] = useState(initialFormState);

  useEffect(() => {
    setForm(initialData || initialFormState);
  }, [initialData]);

  const handleChange = ({ target: { name, value } }) => {
    setForm((prev) => ({ ...prev, [name]: value }));
  };

  const handleMaskedChange = (name, value, maskFn) => {
    const maskedValue = maskFn(value.replace(/\D/g, ""));
    setForm((prev) => ({ ...prev, [name]: maskedValue }));
  };

  const resetForm = () => setForm(initialFormState);

  const handleClose = () => {
    resetForm();
    onClose();
  };

  const cpfCnpjMask = (value) => {
    const numericValue = value.replace(/\D/g, "");
    if (numericValue.length <= 11) {
      return numericValue.replace(
        /^(\d{3})(\d{3})(\d{3})(\d{2})$/,
        (_, p1, p2, p3, p4) => `${p1}.${p2}.${p3}-${p4}`
      );
    } else if (numericValue.length <= 14) {
      return numericValue.replace(
        /^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/,
        (_, p1, p2, p3, p4, p5) => `${p1}.${p2}.${p3}/${p4}-${p5}`
      );
    }
    return value;
  };

    const phoneMask = (value) => {
        const cleanedValue = value.replace(/\D/g, "");
        if (/^(\d{2})(\d{2})(\d{4,5})(\d{4})$/.test(cleanedValue)) {
            return cleanedValue.replace(
                /^(\d{2})(\d{2})(\d{4,5})(\d{4})$/,
                (_, p1, p2, p3, p4) => `+${p1} (${p2}) ${p3}-${p4}`
            );
        } else if (/^(\d{2})(\d{4,5})(\d{4})$/.test(cleanedValue)) {
            return cleanedValue.replace(
                /^(\d{2})(\d{4,5})(\d{4})$/,
                (_, p1, p2, p3) => `(${p1}) ${p2}-${p3}`
            );
        }
        return value;
    };

  return (
    <Dialog open={open} onClose={handleClose} maxWidth="sm" fullWidth>
      <DialogTitle>
        {initialData ? "Editar Cooperado" : "Novo Cooperado"}
      </DialogTitle>
      <DialogContent dividers>
        <Grid container spacing={2}>
          {[
            { label: "Nome", name: "nome", type: "text" },
            {
              label: "CPF/CNPJ",
              name: "cpf_cnpj",
              type: "text",
              maskFn: cpfCnpjMask,
            },
            {
              label: "Data de Nascimento/Constituição",
              name: "data_nascimento_constituicao",
              type: "date",
              defaultValue: new Date().toISOString().split("T")[0],
            },
            {
              label: "Renda/Faturamento",
              name: "renda_faturamento",
              type: "number",
            },
            {
              label: "Telefone",
              name: "telefone",
              type: "text",
              maskFn: phoneMask,
            },
            { label: "Email", name: "email", type: "email" },
          ].map(({ label, name, type, maskFn, defaultValue }) => (
            <Grid item xs={name === "email" ? 12 : 6} key={name}>
              <TextField
                label={label}
                name={name}
                type={type}
                value={form[name] || defaultValue || ""}
                onChange={(e) =>
                  maskFn
                    ? handleMaskedChange(name, e.target.value, maskFn)
                    : handleChange(e)
                }
                fullWidth
                InputLabelProps={type === "date" ? { shrink: true } : undefined}
              />
            </Grid>
          ))}
        </Grid>
      </DialogContent>
      <DialogActions>
        <Button onClick={handleClose}>Cancelar</Button>
        <Button
          onClick={() => onSubmit(form)}
          variant="contained"
          color="primary">
          Salvar
        </Button>
      </DialogActions>
    </Dialog>
  );
}
