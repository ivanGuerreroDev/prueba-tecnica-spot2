import * as React from 'react';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import IconButton from '@mui/material/IconButton';
import DeleteIcon from '@mui/icons-material/Delete';
import OpenInNewIcon from '@mui/icons-material/OpenInNew';
import LinearProgress from '@mui/material/LinearProgress';
import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogTitle from '@mui/material/DialogTitle';
import useMediaQuery from '@mui/material/useMediaQuery';
import { useTheme } from '@mui/material/styles';
import Button from '@mui/material/Button';

const PUBLIC_URL =import.meta.env.VITE_HOSTAPI;
const baseUrl = PUBLIC_URL+'/api/url';
export default function UrlList({
    data,
    onRemove,
    loading
}) {
    const theme = useTheme();
    const fullScreen = useMediaQuery(theme.breakpoints.down('md'));
    const [open, setOpen] = React.useState(false);
    const [id, setId] = React.useState(null);
    const handleClickOpen = (id) => {
        setId(id);
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
    };
    const handleRemove = () => {
        onRemove(id);
        setOpen(false);
    };
    return (
        <>
            <TableContainer component={Paper}>
                <Table sx={{ minWidth: 650 }} aria-label="simple table">
                    <TableHead>
                        <TableRow>
                            <TableCell>ID</TableCell>
                            <TableCell>Code</TableCell>
                            <TableCell>Original Url</TableCell>
                            <TableCell align="right">Actions</TableCell>
                        </TableRow>
                    </TableHead>
                    {
                        loading ? (
                            <TableBody>
                                <TableRow>
                                    <TableCell colSpan={4} align="center">
                                        <LinearProgress />
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        ) : (
                            <TableBody>
                                {data.map((row) => (
                                    <TableRow
                                        key={row.name}
                                        sx={{
                                            border: '1px solid #ccc',
                                            borderRadius: '5px',
                                        }}
                                    >
                                        <TableCell component="th" scope="row">
                                            {row.id}
                                        </TableCell>
                                        <TableCell>{row.shortened_url}</TableCell>
                                        <TableCell>{row.original_url}</TableCell>
                                        <TableCell align="right">
                                            <IconButton
                                                aria-label="open"
                                                href={`${baseUrl}/${row.shortened_url}`}
                                                target="_blank"
                                                color="primary"
                                            >
                                                <OpenInNewIcon />
                                            </IconButton>
                                            <IconButton
                                                aria-label="delete"
                                                onClick={() => handleClickOpen(row.id)}
                                                color="error"
                                            >
                                                <DeleteIcon />
                                            </IconButton>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        )
                    }

                </Table>
            </TableContainer>
            <Dialog
                fullScreen={fullScreen}
                open={open}
                onClose={handleClose}
                aria-labelledby="responsive-dialog-title"
            >
                <DialogTitle id="responsive-dialog-title">
                    {"Are you sure you want to delete this item?"}
                </DialogTitle>
                <DialogActions>
                    <Button autoFocus onClick={handleClose}>
                        Cancel
                    </Button>
                    <Button onClick={handleRemove} autoFocus color="error">
                        Delete
                    </Button>
                </DialogActions>
            </Dialog>
        </>
    );
}
