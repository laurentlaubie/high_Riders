

    //     /**
    //     * @Route("/{id}/delete", name="spot_delete", methods={"POST"})
    //     */
    //     public function delete(Request $request, Spot $spot): Response
    //     {
    //         if ($this->isCsrfTokenValid('delete' . $spot->getId(), $request->request->get('_token'))) {
    //             $entityManager = $this->getDoctrine()->getManager();
    //             $entityManager->remove($spot);
    //             $entityManager->flush();
    //         }

    //         return $this->redirectToRoute('backoffice_spots', [], Response::HTTP_SEE_OTHER);
    //     }
 